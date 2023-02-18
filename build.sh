# rm -r ./docker-volumes

docker compose up --build -d

# remove all unused images
docker rmi $(docker images -f "dangling=true" -q)