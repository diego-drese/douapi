/**
    Intall:
    sudo apt-get install -y nodejs
    sudo apt-get install -y xvfb x11-xkb-utils xfonts-100dpi xfonts-75dpi xfonts-scalable xfonts-cyrillic x11-apps clang libdbus-1-dev libgtk2.0-dev libnotify-dev libgconf2-dev libasound2-dev libcap-dev libcups2-dev libxtst-dev libxss1 libnss3-dev gcc-multilib g++-multilib
    npm install --save nightmare
    npm install --save moment
    npm install --save vo

    To debug use:
    DEBUG=nightmare* xvfb-run -a node downlowd-dou.js

    Parameters:
    withPreviousDay: Execute first e second lines
    onlyPreviousDay: Execute only second line
    dateExecute=YYYY-mm-dd: Execute a day specific

    Cron
    0 0 * * *  cd /var/www/douapi.com.br/current/automation &&  xvfb-run -a node downlowd-dou.js >> /var/www/douapi.com.br/storage/logs/laravel-$(date +\%Y-\%m-\%d).log
    0 9 * * *  cd /var/www/douapi.com.br/current/automation &&  xvfb-run -a node downlowd-dou.js withPreviousDay >> /var/www/douapi.com.br/storage/logs/laravel-$(date +\%Y-\%m-\%d).log
    0 12 * * * cd /var/www/douapi.com.br/current/automation &&  xvfb-run -a node downlowd-dou.js >> /var/www/douapi.com.br/storage/logs/laravel-$(date +\%Y-\%m-\%d).log
    0 15 * * * cd /var/www/douapi.com.br/current/automation &&  xvfb-run -a node downlowd-dou.js >> /var/www/douapi.com.br/storage/logs/laravel-$(date +\%Y-\%m-\%d).log
    0 18 * * * cd /var/www/douapi.com.br/current/automation &&  xvfb-run -a node downlowd-dou.js >> /var/www/douapi.com.br/storage/logs/laravel-$(date +\%Y-\%m-\%d).log
    0 21 * * * cd /var/www/douapi.com.br/current/automation &&  xvfb-run -a node downlowd-dou.js withPreviousDay >> /var/www/douapi.com.br/storage/logs/laravel-$(date +\%Y-\%m-\%d).log
*/

const Nightmare     = require('nightmare');
const fs            = require('fs');
const moment        = require('moment');
const vo            = require('vo');
var argsArray       = process.argv.slice(2);
var withPreviousDay = false;
var onlyPreviousDay = false;
var dateExecute     = false;
var urlPath         = 'https://inlabs.in.gov.br';
var urlLogin        = urlPath+'/acessar.php';
argsArray.forEach(function(arg) {
    if(arg=='withPreviousDay') withPreviousDay= true;
    if(arg=='onlyPreviousDay') onlyPreviousDay= true;
    if(arg.includes('dateExecute')) {
        var dateExecuteSplit = arg.split('=');
        dateExecute = dateExecuteSplit[1];
    }
});

console.log(moment().format('YYYY-MM-DD HH:mm:ss')+ ' - Download dou, start [withPreviousDay:'+withPreviousDay+'] [onlyPreviousDay:'+onlyPreviousDay+'] [dateExecute:'+dateExecute+']');
vo(run)(function(err, result) {
    if (err) throw err
    console.log(moment().format('YYYY-MM-DD HH:mm:ss')+ ' - Download dou, finished');
})
var getParameterByName  = function(name, url) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
       results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
let downloadZip = function (){
    var getParameterByName  = function(name, url) {
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

    var el = document.querySelectorAll("[href*='.zip']");
    var searchResults = [];
    el.forEach(function(result) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", result.href, false);
        xhr.overrideMimeType("text/plain; charset=x-user-defined");
        xhr.send();
        searchResults.push({'name': getParameterByName('dl', result.href), 'data':xhr.responseText});
    });
    return searchResults;
}
let saveZip  = function (result){
    result.forEach(function(r) {
        var buffer = new ArrayBuffer(r['data'].length);
        var bytes = new Uint8Array(buffer);
        for (var i = 0; i < r['data'].length; i++) {
            bytes[i] = r['data'].charCodeAt(i);
        }
        var pathFile = '../storage/douapi/dou-zip/'+r['name'];
        fs.writeFileSync(pathFile, new Buffer.from(bytes), 'binary');
        console.log(moment().format('YYYY-MM-DD HH:mm:ss')+ ' - Download dou, save zip['+pathFile+']');
    })
}

function *run() {
    var nightmare   = Nightmare({show: true, waitTimeout: 1200000, gotoTimeout: 1200000, loadTimeout:1200000, executionTimeout:1200000});
    var links       = [];
    yield nightmare
        .goto(urlLogin)
        .insert('form[action="logar.php"] #email', 'admin@oka6.com.br')
        .insert('form[action="logar.php"] #password', 'cr2DdJ4zCDF')
        .click('input[value="logar"]')
        .wait(6000)
        .evaluate(function(){
            var el = document.querySelectorAll("[href*='?p=']");
            var searchResults = [];
            el.forEach(function(r) {
                searchResults.push(r.href)
            });
            return searchResults;
        }).then(function(result) {
            links = result;
        })

    var count = 0;
    var link  = '';
    var date  = '';
    for(var i = 0; i<links.length; i++){
        link = links[i];
        date = getParameterByName('p', link);
        if(date!=""){
            count++;
            if(dateExecute==date || (!dateExecute && ((!onlyPreviousDay && count==1) || (onlyPreviousDay && count==2) || (withPreviousDay && count<=3)))){
                yield nightmare
                    .goto(link)
                    .wait(1000)
                    .evaluate(downloadZip)
                    .then(saveZip)
            }

        }
    }
    yield nightmare.end()
}
