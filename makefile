PHP_IMAGE := php:7.1.9-apache
CONT_NAME := yblib
DOCKER_OPT := -it --rm -v$(shell pwd)/public:/var/www/html --name ${CONT_NAME}

all:
	@echo Usage:
	@echo make run
	@echo make shell
	@echo make tap
	@echo make stop

.PHONY: run shell tap stop
run:
	@docker run ${DOCKER_OPT} -d -p8888:80 ${PHP_IMAGE}

shell:
	@docker run ${DOCKER_OPT} ${PHP_IMAGE} bash

tap:
	@docker exec -it ${CONT_NAME} bash

stop:
	@docker stop ${CONT_NAME}

.SILENT:
%:
	@:
