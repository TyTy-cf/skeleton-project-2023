#!/bin/bash

GID=`id -G | cut -f1 -d ' '`

# Get stack path & move into it.
STACK_PATH=`realpath "$(dirname $0)"`
echo -n "Change directory to $STACK_PATH..."
cd $STACK_PATH
echo " Done."

php php bin/console cache:clear -n

if [ $? -eq 0 ]; then
	echo " OK."
else
	echo " KO."
	1>&2 echo "Cannot clear cache."
	exit 2
fi

# Apply migration
echo -n "Apply migration..."
php php bin/console doctrine:migrations:migrate -n

if [ $? -eq 0 ]; then
	echo " OK."
else
	echo " KO."
	1>&2 echo "Cannot apply migrations in database."
	exit 3
fi

# Clear Cache
echo -n "Clear cache..."
php php bin/console cache:clear -n

if [ $? -eq 0 ]; then
	echo " OK."
else
	echo " KO."
	1>&2 echo "Cannot clear cache."
	exit 2
fi
