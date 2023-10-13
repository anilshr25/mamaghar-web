#!/bin/bash

/bin/bash  -c "php vendor/bin/envoy run deploy-stage"
/bin/bash  -c "php vendor/bin/envoy run migrate_db_stage"
