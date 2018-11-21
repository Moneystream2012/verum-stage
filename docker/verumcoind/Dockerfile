FROM php:7.1-cli

ENV VERSION  1.0.0.1

RUN apt-get update && apt-get install -y libpq-dev wget
RUN docker-php-ext-install pdo_pgsql

RUN wget -O /tmp/verumcoind-linux.tar.gz https://github.com/verumcoin-project/verumcoin/releases/download/v$VERSION/verumcoind-linux.tar.gz
RUN tar xzf /tmp/verumcoind-linux.tar.gz -C /usr/bin

RUN mkdir /data
RUN ln -s /data /root/.VerumCoin
WORKDIR /data
VOLUME /data

RUN rm -rf /tmp/verumcoind-linux.tar.gz
RUN rm -r /var/lib/apt/lists/*

ENTRYPOINT ["verumcoind", "-printtoconsole"]
EXPOSE 9555 9554 19555 19554
