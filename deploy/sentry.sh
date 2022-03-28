#!/bin/bash
# Assumes you're in a git repository
if [ -e ".env" ]
then
    source .env
elif [ -e ".env.example" ]
then
    source .env.example
else
    echo '.env.example 缺少sentry环境变量'
    exit 1
fi

if [[ -z $SENTRY_AUTH_TOKEN || -z $SENTRY_ORG ]]
then
    echo '.env.example 缺少 SENTRY_AUTH_TOKEN, SENTRY_ORG'
    exit 1
fi

export SENTRY_ORG
export SENTRY_AUTH_TOKEN
VERSION=$(sentry-cli releases propose-version)


# 替换sentry配置版本号
mv config/sentry.php config/sentry.php.bak
cat config/sentry.php.bak | while read line
do
   echo ${line/\'release\'*/\'release\' => \'$VERSION\',} >> config/sentry.php
done
rm -f config/sentry.php.bak‘


if [ "$1" = "production" ]
then
# Create a release
sentry-cli --url https://sentry.tool.zwcfgl.com/ releases new -p $APP_NAME $VERSION

# Associate commits with the release
sentry-cli --url https://sentry.tool.zwcfgl.com/ releases set-commits --auto $VERSION

# Tell Sentry When You Deploy a Release
sentry-cli --url https://sentry.tool.zwcfgl.com/ releases deploys $VERSION new -e 'production'

fi
