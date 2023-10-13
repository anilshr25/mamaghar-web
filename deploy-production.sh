#!/bin/bash

/bin/bash  -c "php vendor/bin/envoy run deploy"
/bin/bash  -c "php vendor/bin/envoy run migrate_db"

echo "Clearing Cache."
bash purgcache.sh
