#!/bin/sh
# 현 배치파일 경로 확인
batch_dir=$(cd "$(dirname "$0")" && pwd)

#######################################################################
# Daily 뉴스 파싱 및 업데이트 ##

# NBA Player (widget -> Spo-bit)
	cd $batch_dir/05.ETC/web/03.Daily_News/NBA
# 선수관련 뉴스 파싱하여 DB에 업데이트 (메인뉴스에 있는 타이틀 링크를 통해 서브 뉴스 파싱)
	php 01.NBA_Player_News_Down_Update_Web_tmp-widget_daily_news.php
	#>> log/$(date '+%Y-%m-%d')_01.NBA_Player_News_Down_Update_Web_tmp.log


# 최신 뉴스 업데이트 (tmp -> live)
	php 02.NBA_Player_News_Update-Web_live-daily_news.php
