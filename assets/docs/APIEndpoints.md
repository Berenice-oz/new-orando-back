# API Endpoint O-Rando

## Areas

    - https://orando.me/o/api/areas [GET] (Liste des régions)
    - https://orando.me/o/api/areas/{id} [GET] (Infos sur une région => liste des randos)

## Participant

    - https://orando.me/o/api/participant [POST] (Ajout d'une participation):
    ```{"user":1,"walk":1}```
    - https://orando.me/o/api/participant [PATCH] (Modification d'une participation):
    ```{"user":1,"walk":1,"requestStatus":2}```
    - https://orando.me/o/api/participant_check [POST] (Vérification d'une participation d'un utilisateur à une rando ):
    ```{"user":1```,"walk":1}```


## Walks

    - https://orando.me/o/api/walks [POST] (Création d'une randonnée):
    ```{
	"title":"Lorem ipsum dolor sit amet",
	"startingPoint":"Lorem ipsum",
	"endPoint":"Lorem ipsum",
	"date":"25-05-2021T21:00:00",
	"duration":"3heures30",
	"difficulty":"Moyen",
	"elevation":200,
	"maxNbPersons":3,
	"description":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ut massa feugiat, porttitor lorem at, commodo nisl.",
	"kilometre":12,
	"area":5,
	"creator":1,
	"tags": [2,3]
    }```
    - https://orando.me/o/api/walks/{id} [PATCH] (Modification d'une randonnée):
    ```{
	"title":"Lorem ipsum dolor sit amet",
	"startingPoint":"Lorem ipsum",
	"endPoint":"Lorem ipsum",
	"date":"25-05-2021T21:00:00",
	"duration":"3heures30",
	"difficulty":"Moyen",
	"elevation":200,
	"maxNbPersons":3,
	"description":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ut massa feugiat, porttitor lorem at, commodo nisl.",
	"kilometre":12,
	"area":5,
	"creator":1,
	"tags": [2,3]
    }```
    - https://orando.me/o/api/walks/{id} [DELETE] (Suppression d'une randonnée)

## Users

    - https://orando.me/o/api/register [POST] (Création d'un utilisateur) (Multipart/formdata)
    - https://orando.me/o/api/users/{id} [POST] (Modification d'un profil utilisateur) (Multipart/formdata)
    - https://orando.me/o/api/contact-user/{id} [POST] (Contact d'un utilisateur , id => destinataire):
    ```{"user":"1","message":" Lorem ipsum dolor sit amet, consectetur adipiscing elit."}``` (user => expéditeur)
    - https://orando.me/o/api/users/{id} [GET] (Infos sur un utilisateur)
