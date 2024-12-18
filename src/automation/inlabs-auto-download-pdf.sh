#!/bin/bash
######################################################################
## INLABS                                                           ##
## Script desenvolvido em bash para download automático de arquivos ##
## Autor: https://github.com/Iakim                                  ##
## A simplicidade é o último grau de sofisticação                   ##
######################################################################



## Tipos de Diários Oficiais da União permitidos: do1 do2 do3 (Contempla as edições extras) ##
tipo_dou="do1 do2 do3"
url="http://18.231.87.145/douapi"
## Altere daqui para baixo por sua conta e risco ##
dia=`date +%d`
mes=`date +%m`
ano=`date +%Y`


## DOWNLOAD ##
for secao in $tipo_dou;
do
        echo "curl --silent -fL '"$url"/"$ano"_"$mes"_"$dia"_ASSINADO_"$secao".pdf' -H 'origem: 736372697074' --output "$ano"_"$mes"_"$dia"_ASSINADO_"$secao".pdf"
        download="curl --silent -fL '"$url"/"$ano"_"$mes"_"$dia"_ASSINADO_"$secao".pdf' -H 'origem: 736372697074' --output "../storage/douapi/dou-pdf-attachment/$ano"_"$mes"_"$dia"_ASSINADO_"$secao".pdf"
        echo $download > $ano-$mes-$dia-$secao.sh
        sh $ano-$mes-$dia-$secao.sh
        rm -rf $ano-$mes-$dia-$secao.sh

        for seq in A B C D E F G H I J K L M N O P Q R S T U V X W Y Z
        do
                echo "curl --silent -fL  '"$url"/"$ano"_"$mes"_"$dia"_ASSINADO_"$secao"_extra_"$seq".pdf' -H 'origem: 736372697074' --output "../storage/douapi/dou-pdf-attachment/$ano"_"$mes"_"$dia"_ASSINADO_"$secao"_extra_"$seq""
                download="curl --silent -fL '"$url"/"$ano"_"$mes"_"$dia"_ASSINADO_"$secao"_extra_"$seq".pdf' -H 'origem: 736372697074' --output "../storage/douapi/dou-pdf-attachment/$ano"_"$mes"_"$dia"_ASSINADO_"$secao"_extra_"$seq""
                echo $download > $ano-$mes-$dia-$secao.sh
                sh $ano-$mes-$dia-$secao.sh
                rm -rf $ano-$mes-$dia-$secao.sh
                if [ -f "../storage/douapi/dou-pdf-attachment"/"$ano"_"$mes"_"$dia"_ASSINADO_"$secao"_extra_"$seq" ]; then
                        echo "Remove"
                        rm -rf "../storage/douapi/dou-pdf-attachment"/"$ano"_"$mes"_"$dia"_ASSINADO_"$secao"_extra_"$seq"
                fi
        done
done

rm -rf cookies.iakim
exit 0
