#!/bin/sh
# 현 배치파일 경로 확인
batch_dir=$(cd "$(dirname "$0")" && pwd)

# [ Store - Bitcoin Deposit ] ##
	cd $batch_dir/05.ETC/web/01.Carry_Forward_Bitcoin

# Store - Bitcoin Deposit(Today 잔금 tomorrow 이월하기 및  after tomorrow DB 추가)
	php carry_forward_bitcoin.php
