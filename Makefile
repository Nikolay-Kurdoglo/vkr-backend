build-dev:
	@docker build . \
		-f docker/php/Dockerfile \
		--platform=linux/amd64 \
		-t vkr_backend