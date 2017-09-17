PHP_IMAGE := php:7.1.9-apache
DOCKER_OPT := run -it --rm -v$(shell pwd)/public:/var/www/html

all:
	@echo Usage:
	@echo make run
	@echo make shell

.PHONY: run shell
run:
	@docker ${DOCKER_OPT} -d -p8888:80 ${PHP_IMAGE}

shell:
	@docker ${DOCKER_OPT} ${PHP_IMAGE} bash

.SILENT:
%:
	@:
