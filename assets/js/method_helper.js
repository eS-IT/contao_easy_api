/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  method_helper.js
 * @version     1.0.0
 * @since       18.09.13 - 14:34
 */


/**
 * Sendet Daten mit der angegebenen Methode.
 * @param method
 * @param url
 * @param data
 */
function executeSend(method, url, data){
    var myJsonString    = JSON.stringify(data);
    var xmlhttp         = new XMLHttpRequest();
    xmlhttp.open(method,url,true);
    xmlhttp.send(myJsonString);
}


/**
 * Liesst die Daten aus dem uebergebenen Formular aus.
 * Das Formular muss ein Feld mit dem Namen "_method" haben,
 * dass die Methode [put|delete] enthaelt.
 * @param formName
 */
function sendData(formName){
    var inputs, index;
    var values  = new Array ();

    var elem    = $(formName);
    var method  = elem._method.value.toUpperCase();
    var url     = elem.action;



    inputs = document.getElementsByTagName('input');
    for (index = 0; index < inputs.length; ++index) {
        if(inputs[index].type == 'text'){
            //console.log(inputs[index].name + ': ' + inputs[index].value);
            values[inputs[index].name] = inputs[index].value;
        }
    }

    console.log('Form: ' + formName);
    console.log('Method: ' + method);
    console.log('URL: ' + url);
    console.log(values);

    executeSend(method, url, values);
}
