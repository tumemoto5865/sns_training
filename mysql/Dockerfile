FROM mysql:8-debian
 
RUN apt-get update && apt-get install -y locales \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*
  
RUN sed -i -E 's/# (ja_JP.UTF-8)/\1/' /etc/locale.gen \
  && locale-gen
  
ENV LANG ja_JP.UTF-8
 
CMD ["mysqld", "--character-set-server=utf8mb4", "--collation-server=utf8mb4_general_ci"]
