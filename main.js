
var TOPIC_TABLE = document.getElementById('topic-table');
var TOPIC_TOEVOEGEN_A = document.getElementById('topic-toevoegen-a');

function addTopic(){//vooral via js
    if (TOPIC_TOEVOEGEN_A.innerText === 'Annuleren'){
        TOPIC_TOEVOEGEN_A.innerText = 'Topic toevoegen';
        TOPIC_TABLE.deleteRow(0);
    }else{
        TOPIC_TOEVOEGEN_A.innerText = 'Annuleren';
        //elementen
        var element = document.createElement('TD');
        var form = document.createElement('FORM');
        var topic_title_input = document.createElement('textarea');
        var topic_title_submit = document.createElement('input');
        //attributen
        form.setAttribute('action', 'submit_topic.php');
        form.setAttribute('method', 'POST');
        form.setAttribute('class', 'input-form');

        topic_title_input.name = 'topic-title-input';

        topic_title_submit.setAttribute('type', 'submit');
        //append aan table
        form.appendChild(topic_title_input);
        form.appendChild(topic_title_submit);
        element.appendChild(form);
        TOPIC_TABLE.insertRow(0).appendChild(element);

        // <form action='submit_topic.php' method='post'> <input type=textarea> <input type=submit> </form>
    }
}

function addThread(){//vooral via php
    window.location.href = window.location.href + '&addThread=true';
}


function verwijderThread(){
    //Eerst kijken welke thread het is, doe je met thread ID in de URL
    //Te verwijderen: de thread zelf & alle reacties
    var url = window.location.href;
    var temp = url.slice(url.indexOf('&'));
    var thread_ID = temp.slice(temp.indexOf('='));
    thread_ID = thread_ID.slice(1);

    var xhr;
    if (window.XMLHttpRequest){
        xhr = new XMLHttpRequest();
    }
    if (window.ActiveXObject){
        xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }
    var data = 'type=thread&ID=' + thread_ID;
    xhr.open("POST","verwijder_handler.php","true");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);
}
function removeTopic(){
    var topic = prompt('Voer topic naam in');
    if (topic !== ''){
        var xhr;
        if (window.XMLHttpRequest){
            xhr = new XMLHttpRequest();
        }
        if (window.ActiveXObject){
            xhr = new ActiveXObject('Microsoft.XMLHTTP');
        }
        var data = 'type=topic&ID=' + topic;
        xhr.open("POST","verwijder_handler.php","true");
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xhr.send(data);
    }
}
