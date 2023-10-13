#!/bin/bash

#Auth Keys
authEmail="anilshr25@gmail.com"
authKey="d0c729337474d1a8234d5cb6e507366302965"
parametersVariable="-H X-Auth-Email:$authEmail -H X-Auth-Key:$authKey"

#Additional Options
contentType="\"Content-Type:application/json"\"
dataFile='{"purge_everything":true}'

#Zone IDs
allZones=("dc47c1983c448292f902f70fad9d9f25")

#Purge Cache for each zone
for zoneId in ${allZones[@]};
do
  websiteVariable="https://api.cloudflare.com/client/v4/zones/$zoneId/purge_cache"
  entireURL="curl -X POST "$websiteVariable" "$parametersVariable" -H "$contentType" --data "'$dataFile'" "
  echo "Entire URL IS: $entireURL"
  result=`$entireURL`
  eval $entireURL
done

