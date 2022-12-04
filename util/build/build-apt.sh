#/bin/bash

#
# Parameters:
#
# 1: froxlor version to release
# 2: whether to use an existing archive (0) or checkout git (1) for a new release
# 3: git-branch/tag to use
# 4: predecessor version for changelog
# 5: additional number for re-release
#

# standard build
# ./build.sh 0.10.NEW 1 0.10.NEW 0.10.OLD

# test build
# ./build.sh 0.10.EXI 1 0.10.EXI 0.10.OLD 2

# version to release
if [ -z $1 ]; then
    echo "No froxlor version given"
    exit
fi

# 0 = old version | 1 = new/current version
if [ -z $2 ]; then
    echo "Missing version indicator, wether to pull from git or use release-archive'"
    exit
fi

if [ "$2" == 0 ]; then
	if [ -f "froxlor-$1.tar.gz" ]; then
		echo "Okay, found previous version archive"
	else
		echo "Did not find previous version arvhive 'froxlor-$1.tar.gz'"
		exit
	fi
fi

# from where to use the code (tag or main)
if [ -z $3 ]; then
    echo "No git-tag given"
    exit
fi

# prior version
if [ -z $4 ]; then
	echo "no predecessor git-tag/hash given"
	exit
fi

# forget this shit
if [ -z $5 ]; then
	echo "assuming stable dist"
	VERSION_ADD=""
else
	VERSION_ADD="-$5"
fi

FROXLOR_VERSION="$1"
DEB_VERSION="bookworm"
DEB_FILES="/home/froxlor/build/skeleton"
BUILD_DIR="/home/froxlor/build/bookworm"
BUILD_SRC="$BUILD_DIR/var/www/froxlor"

if [ "$2" == 1 ]; then
	echo "-- cloning git repository into $BUILD_SRC --"
	rm -rf "$BUILD_SRC"
	mkdir -p "$BUILD_SRC"
	git clone https://github.com/Froxlor/Froxlor.git "$BUILD_SRC"
	cd "$BUILD_SRC"
	echo "-- checking out tag $3 --"
	git checkout "$3"
	echo "done"

	echo "-- downloading dependencies --"
	cd "$BUILD_SRC"
	composer install --no-dev
	echo "done"
else
	# extract from old archive
  rm -rf "$BUILD_SRC"
  mkdir -p "$BUILD_SRC"
	parentdir="$(dirname "$BUILD_SRC")"
	tar xfz "froxlor-$1.tar.gz" -C "$parentdir"
	cd "$BUILD_SRC"
	echo "done"
fi

echo "-- setting executable permissions for scripts --"
chmod 755 "$BUILD_SRC/install/scripts/config-services.php"
chmod 755 "$BUILD_SRC/install/scripts/switch-server-ip.php"
chmod 755 "$BUILD_SRC/scripts/php-sessionclean.php"
echo "done"

echo "-- copying docs --"
rm -f "$BUILD_DIR/usr/share/doc/froxlor/README"
cp -f "$BUILD_SRC/README.md" "$BUILD_DIR/usr/share/doc/froxlor/README"
echo "done"

if [ "$2" == 1 ]; then
	GIT_HASH=$(git rev-parse --short HEAD)
	GIT_HASH="${GIT_HASH}${VERSION_ADD}"
	GIT_CHANGES=$(git log --no-merges --pretty=format:'%s' $4..$3)
else
	GIT_HASH="1"
  GIT_HASH="${GIT_HASH}${VERSION_ADD}"
	GIT_CHANGES="Rebuild of $1"
fi

echo "-- removing .gitignore / .git files --"
rm -rf "$BUILD_SRC/.git"
rm -rf "$BUILD_SRC/.gitignore"
echo "done"

if [ "$3" != "master" ]; then
	GIT_HASH="1"
	if [ "$5" != "" ]; then
		GIT_HASH="$5"
	fi
fi

echo "-- changelog --"
read -p "The Version for now is: $FROXLOR_VERSION-$GIT_HASH"
gunzip "$BUILD_DIR/usr/share/doc/froxlor/changelog.Debian.gz"
mv "$BUILD_DIR/usr/share/doc/froxlor/changelog.Debian" "$DEB_FILES/changelog.Debian.$GIT_HASH"
# create new changelog file
cd "$DEB_FILES"
rm -f "$DEB_FILES/debian/changelog"
dch --create --package=froxlor --urgency=low -v "$FROXLOR_VERSION-$GIT_HASH" --distribution=unstable -M --empty
# add git-log lines to changelog
echo "$GIT_CHANGES" > /tmp/git.changes
while read i; do dch -a "$i" -M; done < /tmp/git.changes
rm -f /tmp/git.changes

# open changelog to check/edit
nano "$DEB_FILES/debian/changelog"

cp "$DEB_FILES/debian/changelog" "$BUILD_DIR/usr/share/doc/froxlor/changelog.Debian"
gzip -n --best "$BUILD_DIR/usr/share/doc/froxlor/changelog.Debian"
echo "done"

cd "$BUILD_DIR"
# replace version in control file
sed "s/FVERSION/$FROXLOR_VERSION/g" "$DEB_FILES/debian/control" > "$BUILD_DIR/DEBIAN/control"
sed -i "s/GHASH/$GIT_HASH/g" "$BUILD_DIR/DEBIAN/control"
# replace version in froxlor branding
sed -i "s/const BRANDING = '';/const BRANDING = '-$GIT_HASH';/g" "$BUILD_SRC/lib/Froxlor/Froxlor.php"

cd "$BUILD_DIR"
cd ..
fakeroot dpkg-deb -v --build "bookworm"
export GPG_TTY=`tty`
#	debsigs --sign=origin -k F6B4A8704F9E9BBC "bookworm.deb"

lintian "bookworm.deb"

parentdir="$(dirname "$BUILD_DIR")"
mv "$parentdir/bookworm.deb" "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"

# add to repository
if [ "$2" == 1 ]; then
	echo "-- adding to debian repo --"
	cd "/home/froxlor/deb-repository/debian"
	reprepro -V includedeb stretch "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
	reprepro -V includedeb buster "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
	reprepro -V includedeb bullseye "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
	reprepro -V includedeb bookworm "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
	echo "-- adding to ubuntu repo --"
  cd "/home/froxlor/deb-repository/ubuntu"
  reprepro -V includedeb trusty "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  reprepro -V includedeb xenial "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  reprepro -V includedeb bionic "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  reprepro -V includedeb focal "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  reprepro -V includedeb jammy "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  echo "done"
else
  echo "-- adding to debian testing repo --"
  cd "/home/froxlor/deb-repository/debian"
  reprepro -C testing -V includedeb stretch "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  reprepro -C testing -V includedeb buster "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  reprepro -C testing -V includedeb bullseye "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  reprepro -C testing -V includedeb bookworm "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  echo "-- adding to ubuntu repo --"
  cd "/home/froxlor/deb-repository/ubuntu"
  reprepro -C testing -V includedeb trusty "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  reprepro -C testing -V includedeb xenial "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  reprepro -C testing -V includedeb bionic "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  reprepro -C testing -V includedeb focal "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  reprepro -C testing -V includedeb jammy "$parentdir/froxlor-$FROXLOR_VERSION-$GIT_HASH.deb"
  echo "done"
fi
