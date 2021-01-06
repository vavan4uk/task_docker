# Time tracking source, Symfony 4.4<br />
https://github.com/vavan4uk/task_docker.git<br />
<br />
Technical Requirements<br />
Before installation make sure that you have installed git/docker-compose<br />
<br />
Installation<br />
cd ~/ <br />
git clone https://github.com/vavan4uk/task_docker.git task <br />
cd task <br />
docker-compose --version<br />
docker-compose pull --ignore-pull-failures || true<br />
docker-compose build --pull<br />
docker-compose up -d<br />
docker-compose exec php bin/console cache:clear<br />
docker-compose exec php bin/console doctrine:schema:create<br />
docker-compose exec php bin/console doctrine:schema:update --force<br />
open http://localhost<br />
<br />
<br />
<br />
<br />
For run functionality test ( after complete instalation ) <br />
cd ~/ <br />
cd task <br />
docker-compose exec php vendor/bin/codecept run --steps <br />
