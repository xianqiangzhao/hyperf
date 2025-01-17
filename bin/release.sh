#!/usr/bin/env bash
set -e

if (( "$#" != 1 ))
then
    echo "Tag has to be provided"

    exit 1
fi

CURRENT_BRANCH="master"
VERSION=$1
BASEPATH=$(cd `dirname $0`; cd ../src/; pwd)

# Always prepend with "v"
if [[ $VERSION != v*  ]]
then
    VERSION="v$VERSION"
fi

repos=$(ls $BASEPATH)

for REMOTE in $repos
do
    echo ""
    echo ""
    echo "Releasing $REMOTE";
    TMP_DIR="/tmp/hyperf-split"
    REMOTE_URL="git@github.com:hyperf-cloud/$REMOTE.git"

    rm -rf $TMP_DIR;
    mkdir $TMP_DIR;

    (
        cd $TMP_DIR;

        git clone $REMOTE_URL .
        git checkout "$CURRENT_BRANCH";

        git tag $VERSION
        git push origin --tags
    )
done