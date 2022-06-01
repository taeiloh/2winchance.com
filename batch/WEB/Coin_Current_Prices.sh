#!/bin/sh
# 현 배치파일 경로 확인
batch_dir=$(cd "$(dirname "$0")" && pwd)

# 경로 이동
	cd $batch_dir/02.Coin_Current_Prices

# Bitcoin 시세 조회 및 업데이트
	#php 01.Coin_Current_Prices_Update.php bitcoin

# DSN 시세 조회 및 업데이트
	php 01.Coin_Current_Prices_Update.php dsn