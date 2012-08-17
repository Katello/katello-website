#!/bin/bash
# Script for updating the apidoc subpath based on the latest
# katello-api-doc RPM
# it downloads the latest api-doc rpm, checks if it was not already
# published, if not, updates it and commits the change. All you need
# then is to push it.

SCRIPT_DIR=$(dirname $(readlink -f $BASH_SOURCE))
REPO=http://fedorapeople.org/groups/katello/releases/yum/nightly/RHEL/6Server/x86_64/
LATEST_RPM_NVRE=$(curl $REPO 2>/dev/null | grep katello-api-docs | tail -n 1 | sed 's/<[^>]*>//g' | awk '{print $1}')
RPM_URL=$REPO/$LATEST_RPM_NVRE
RPM_FILE=$SCRIPT_DIR/$LATEST_RPM_NVRE
RPM_CONTENT_DIR=$SCRIPT_DIR/apidoc_rpm_content
WEB_DIR=$SCRIPT_DIR/php

# Stores the latest version of the API
HEAD_FILE=$SCRIPT_DIR/apidoc.head

if [ -e $RPM_CONTENT_DIR ]; then
    echo "$RPM_CONTENT_DIR exists. Get rid of it and run the script again" >&2
    exit 1
fi

if [ $? -ne 0 ]; then
    echo "Could not find the latest api-doc RPM" >&2
    exit 2
fi

if [ -e $HEAD_FILE ] && [ "$(cat $HEAD_FILE)" = $LATEST_RPM_NVRE ]; then
    echo "$LATEST_RPM_NVRE is already published" >&2
    exit 0
fi

if ! wget $RPM_URL -O $RPM_FILE > /dev/null; then
    echo "Could not download $RPM_URL"
    exit 3
fi

mkdir $RPM_CONTENT_DIR
pushd $RPM_CONTENT_DIR &>/dev/null

rpm2cpio $RPM_FILE | cpio -idmv --no-absolute-filenames &>/dev/null

cd $RPM_CONTENT_DIR/usr/share/doc/*
cp apidoc.html apidoc/index.html
sed -i 's/\.\/apidoc/..\/apidoc/g' apidoc/index.html
cp -r apidoc.html apidoc $WEB_DIR

popd  &>/dev/null

rm -rf $RPM_CONTENT_DIR $RPM_FILE

echo $LATEST_RPM_NVRE > $HEAD_FILE
git add -A $WEB_DIR/apidoc* $HEAD_FILE

if git commit -m "Apidoc update to $LATEST_RPM_NVRE" -e; then
   echo "The Api doc has been updated, now run git push to publish it" >&2
else
    git checkout -- $WEB_DIR/apidoc* $HEAD_FILE
fi

