#!/bin/bash

YUICOMPRESSOR="/opt/yuicompressor/yuicompressor-2.4.8.jar"

echo "Creating JS... "
java -jar $YUICOMPRESSOR public/js/jquery-1.11.1.min.js > public/js/all.js
java -jar $YUICOMPRESSOR public/js/bootstrap.min.js >> public/js/all.js
java -jar $YUICOMPRESSOR public/js/bootstrap-table.min.js >> public/js/all.js
java -jar $YUICOMPRESSOR public/js/bootstrap-table-de-DE.min.js >> public/js/all.js
java -jar $YUICOMPRESSOR public/js/bootstrap-multiselect.js >> public/js/all.js
java -jar $YUICOMPRESSOR public/js/jquery.toaster.js >> public/js/all.js
java -jar $YUICOMPRESSOR public/js/bootstrap-datepicker.js >> public/js/all.js
java -jar $YUICOMPRESSOR public/js/bootstrap-datepicker.de.js >> public/js/all.js
java -jar $YUICOMPRESSOR public/js/elysium.js >> public/js/all.js
echo "Javascript done."



echo "Creating CSS... "
java -jar $YUICOMPRESSOR public/css/elysium.css > public/css/all.css

java -jar $YUICOMPRESSOR public/css/bootstrap.min.css >> public/css/all.css

java -jar $YUICOMPRESSOR public/css/bootstrap-theme.min.css >> public/css/all.css

java -jar $YUICOMPRESSOR public/css/bootstrap-table.min.css >> public/css/all.css

java -jar $YUICOMPRESSOR public/css/datepicker.css >> public/css/all.css

java -jar $YUICOMPRESSOR public/css/datepicker3.css >> public/css/all.css

java -jar $YUICOMPRESSOR public/css/bootstrap-multiselect.css >> public/css/all.css


