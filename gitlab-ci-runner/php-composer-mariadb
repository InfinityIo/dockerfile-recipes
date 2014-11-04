# infinity/gitlab-ci-runner-php-composer-mariadb

FROM ubuntu:14.04
MAINTAINER Nik Rolls "nik@infinity.io"

# This script will start a runner in a docker container.
#
# First build the container and give a name to the resulting image:
# docker build -t gitlabhq/gitlab-ci-runner github.com/gitlabhq/gitlab-ci-runner
#
# Then set the environment variables and run the gitlab-ci-runner in the container:
# docker run -e CI_SERVER_URL=https://ci.example.com -e REGISTRATION_TOKEN=replaceme -e HOME=/root -e GITLAB_SERVER_FQDN=gitlab.example.com gitlabhq/gitlab-ci-runner
#
# After you start the runner you can send it to the background with ctrl-z
# The new runner should show up in the GitLab CI interface on /runners
#
# You can start an interactive session to test new commands with:
# docker run -e CI_SERVER_URL=https://ci.example.com -e REGISTRATION_TOKEN=replaceme -e HOME=/root -i -t gitlabhq/gitlab-ci-runner:latest /bin/bash
#
# If you ever want to freshly rebuild the runner please use:
# docker build -no-cache -t gitlabhq/gitlab-ci-runner github.com/gitlabhq/gitlab-ci-runner

# Get rid of the debconf messages
ENV DEBIAN_FRONTEND noninteractive

# Update your packages and install the ones that are needed to compile Ruby
RUN apt-get update -y
RUN apt-get upgrade -y
RUN apt-get install -y curl libxml2-dev libxslt-dev libcurl4-openssl-dev libreadline6-dev libssl-dev patch build-essential zlib1g-dev openssh-server libyaml-dev libicu-dev

# Download Ruby and compile it
RUN mkdir /tmp/ruby
RUN cd /tmp/ruby && curl --silent ftp://ftp.ruby-lang.org/pub/ruby/2.0/ruby-2.0.0-p481.tar.gz | tar xz
RUN cd /tmp/ruby/ruby-2.0.0-p481 && ./configure --disable-install-rdoc && make install

RUN gem install bundler

# Set an utf-8 locale
RUN echo "LC_ALL=\"en_US.UTF-8\"" >> /etc/default/locale
RUN locale-gen en_US.UTF-8
RUN update-locale LANG=en_US.UTF-8

# Install the runner
RUN curl --silent -L https://gitlab.com/gitlab-org/gitlab-ci-runner/repository/archive.tar.gz | tar xz
RUN cd gitlab-ci-runner.git && bundle install --deployment
RUN apt-get install -y git

######################################################################
# Any extra work required to set up your environment to be done here #
######################################################################

RUN apt-get install -y php5-cli php5-mcrypt php5-xdebug && php5enmod mcrypt && php5enmod xdebug
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin
RUN mv /usr/bin/composer.phar /usr/bin/composer

RUN apt-get install -y software-properties-common
RUN apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xcbcb082a1bb943db
RUN add-apt-repository 'deb http://mirror.aarnet.edu.au/pub/MariaDB/repo/5.5/ubuntu trusty main'
RUN apt-get update -y && apt-get install -y mariadb-server

RUN apt-get install -y php5-mysqlnd && php5enmod mysqlnd

######################################################################

# Prepare a known host file and private key for non-interactive ssh connections
RUN mkdir -p /root/.ssh
RUN touch /root/.ssh/known_hosts
COPY id_rsa /root/.ssh/

# Restore interactive console configurations
ENV DEBIAN_FRONTEND interactive

WORKDIR /gitlab-ci-runner.git

# When the image is started add the remote server key, set up the runner and run it
CMD ssh-keyscan -H $GITLAB_SERVER_FQDN >> /root/.ssh/known_hosts && service mysql start && bundle exec ./bin/setup_and_run
