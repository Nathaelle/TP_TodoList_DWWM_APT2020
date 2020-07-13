// Récupère l'élément cible, dont le contenu sera modifié
var elem = document.getElementById('modContent');
// Met une image animée afin de montrer le chargement en cours du contenu
elem.innerHTML = '<p><img src="img/loading.gif" alt="Chargement" /> Chargement en cours</p>';

//-----------------------------------------------

function getRequest() {
    
    //Récupère la connexion au serveur http
    var request;
    if (window.XMLHttpRequest) {
    request = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        try {
          request = new ActiveXObject("Msxml2.XMLHTTP"); // IE version > 5
        } catch (e) {
          request = new ActiveXObject("Microsoft.XMLHTTP");
        }
    } else {
        request = false;
    }
    return request;
}

var request = getRequest();
request.open('POST', "task_lst");
request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
request.send();

console.log(request);

request.onreadystatechange = function() {
  if(request.readyState == 4 && request.status == 200) {
      var tasks = JSON.parse(request.response);
      var content = "";
      
      for(var task of tasks) {
        content += "<li><img src='img/" + task.image + "' alt='' style='width:50px; margin: 2px 10px; margin-bottom:-10px;'><a href='membre-"+ task.id_task +"'>"+ task.description +"</a> avant le "+ task.deadline +" <a href='del_task-"+ task.id_task +"'>Supprimer</a></li>";
      }
      
    elem.innerHTML = content;
  }
}

/*function changeContent(url, param, id_elem) {
    
    var elem = document.getElementById(id_elem);
    elem.innerHTML = '<img src="img/loading.gif" alt="Chargement" />';
    
    var request = getRequest();
    // Ouvre la connexion en mode asynchrone avec le serveur http avec comme adresse url
    request.open('POST', url, true);

    // Envoie des entêtes pour l'encodage
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    //Envoie les paramètres (même vide) et la requête et active les évènements en mode assynchrone
    request.send(param);

    // Exécution en mode asynchrone de la fonction anonyme dès que l'on obtient une réponse du serveur http
    request.onreadystatechange = function() {
        // Teste si le serveur a tout reçu (200) et que le serveur ait fini (4)
        if (request.status == 200 && request.readyState == 4) {
          elem.innerHTML = request.responseText; // Modifie l'élément cible
        }
    };
}*/



