#!/bin/sh

rm public/images/user/small/*
for i in $(find public/images/user -name "*.jpg" -or -name "*.png" -or -name "*.gif" -type f)
do
    file=$(echo $i | cut -d'/' -f4)
#    convert $i -resize 200 public/images/user/small/$file

done

rm public/images/news/small/*
for i in $(find public/images/news -name "*.jpg" -or -name "*.png" -or -name "*.gif" -type f)
do
    file=$(echo $i | cut -d'/' -f4)
 #   convert $i -resize 350 public/images/news/small/$file

done

rm public/images/offer/small/*
for i in $(find public/images/offer -name "*.jpg" -or -name "*.png" -or -name "*.gif" -type f)
do
    file=$(echo $i | cut -d'/' -f4)
#    convert $i -resize 350 public/images/offer/small/$file

done

rm public/images/photo/small/*
for i in $(find public/images/photo -name "*.jpg" -or -name "*.png" -or -name "*.gif" -type f)
do
    file=$(echo $i | cut -d'/' -f4)
#    convert $i -resize 350 public/images/photo/small/$file

done
