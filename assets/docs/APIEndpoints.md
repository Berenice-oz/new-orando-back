# API Endpoint O-Rando

## Areas

- https://orando.me/o/api/areas [GET] __*Liste des régions*__
- https://orando.me/o/api/areas/{id} [GET] __*Infos sur une région => liste des randos*__

## Participant

- https://orando.me/o/api/participant [POST] __*Ajout d'une participation*__:
```
{"user":1,"walk":1}
```
- https://orando.me/o/api/participant [PATCH] __*Modification d'une participation*__:
```
{"user":1,"walk":1,"requestStatus":2}
```
- https://orando.me/o/api/participant_check [POST] __*Vérification d'une participation d'un utilisateur à une rando*__:
```
{"user":1,"walk":1}
```


## Walks

- https://orando.me/o/api/walks [POST] __*Création d'une randonnée*__: 
```
{"title":"Lorem ipsum dolor sit amet",
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
"tags": [2,3]}
```
    

- https://orando.me/o/api/walks/{id} [PATCH] __*Modification d'une randonnée*__:
```
{"title":"Lorem ipsum dolor sit amet",
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
"tags": [2,3]}
```
- https://orando.me/o/api/walks/{id} [DELETE] __*Suppression d'une randonnée*__

## Users

- https://orando.me/o/api/register [POST] __*Création d'un utilisateur*__ (Multipart/formdata)
- https://orando.me/o/api/users/{id} [POST] __*Modification d'un profil utilisateur*__ (Multipart/formdata)
- https://orando.me/o/api/contact-user/{id} [POST] __*Contact d'un utilisateur*__:
```
{"user":"1","message":" Lorem ipsum dolor sit amet, consectetur adipiscing elit."}
```
***NOTE:
id => destinataire
et user => expéditeur***

- https://orando.me/o/api/users/{id} [GET] __*Infos sur un utilisateur*__
