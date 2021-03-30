#!/bin/bash
######################################################################
## INLABS                                                           ##
## Script desenvolvido em bash para download automático de arquivos ##
## Autor: https://github.com/Iakim                                  ##
## A simplicidade é o último grau de sofisticação                   ##
######################################################################


## Tipos de Diários Oficiais da União permitidos: DO1 DO2 DO3 DO1E DO2E DO3E ##
tipo_dou="DO1 DO2 DO3 DO1E DO2E DO3E"
url="http://18.231.87.145/douapi"
## Altere daqui para baixo por sua conta e risco ##
dia=`date +%d`
mes=`date +%m`
ano=`date +%Y`

## DOWNLOAD ##
for secao in $tipo_dou;
do
        download="curl --silent -fL  '$url/$ano-$mes-$dia-$secao.zip' -H 'origem: 736372697074' --output ../storage/douapi/dou-zip/$ano-$mes-$dia-$secao.zip"
        echo $download > $ano-$mes-$dia-$secao.sh
        sh $ano-$mes-$dia-$secao.sh
        rm -rf $ano-$mes-$dia-$secao.sh
done

rm -rf cookies.iakim
exit 0