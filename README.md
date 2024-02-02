Voici le site web d'un Festival réalisé pour le sujet de TP de Base de données.
Le site possède les fonctionnalités suivantes :
- inscription et connexion d'un utilisateur
- possibilité de réserver des places pour le festival
- stockage dans une base de donnée en hashant le mot de passe de connexion
- récapitulatif de ses réservations disponibles


Sur la page d'accueil (index.php) on peut voir différents articles pouvant mener au site  web ayant écrit l’article sur le festival mais ici les boutons ne mènent sur aucun lien.
On peut ensuite retrouver le formulaire de réservation où l’utilisateur va renseigner ses informations, le type de places, le nombre de places, les jours souhaitées ainsi qu’un commentaire s’il le souhaite.
Si l’utilisateur réserve plus de places que le nombre disponible un message d’erreur lui sera alors affiché lui indiquant le manque de places, bien sûr un utilisateur ne peut pas réserver 0 place.

En validant ce formulaire (formulaire.php) il sera redirigé vers la page (identification.php), sur cette page il lui sera demandé de s’inscrire ou de se connecter avec ses identifiants.
Suite à cela si l’inscription ou l’identification est autorisé il verra alors le récapitulatif de sa commande lié au fichier (recap.php)

Concernant l’inscription c’est le nom d’utilisateur qui doit être unique et ne doit pas déjà être utilisé par un autre utilisateur.
Pour l’identification on va bien sûr vérifier que le mot de passe correspond à l’identifiant de l’utilisateur.

La barre de navigation est la même pour chaque page il y a juste les ancres qui changent selon la page actuel.
Le bouton « Compte » permet à un utilisateur de s’inscrire sans obligatoirement réservé ou alors de se connecter pour consulter ses réservations.
Le bouton « Horaires » quant à lui permet de voir le programme ainsi que le nombre de places restantes pour chaque jour.

Ensuite on retrouve le même bas de page qui permet à l’utilisateur d’accéder aux différents réseaux sociaux du festival ou alors de contacter le festival par téléphone ou par mail.

Concernant le chiffrement du mot de passe de l’utilisateur.
J’ai utilisé le logo VS Code pour programmer mon site cependant en voulant chiffrer le mot de passe en MD5 le logiciel m’a conseillé d’utiliser la fonction password_hash car le chiffrement MD5 est obsolète.
Or ce n’est qu’après que j’ai remarqué que les mots de passe possédaient le même début de chiffrement, j’aurais donc pu utiliser une autre norme de chiffrement que le MD5 tel que le SHA-256.

Une fois que le mot de passe est utilisé pour connecter l’utilisateur, celui n’est pas communiqué entre les différentes pages justement pour éviter que l’on puisse le récupérer pour le déchiffrer, ce qui a pour effet de déconnecter l’utilisateur à chaque actualisation ou redirection de page.

Dans l’URL de certaine page on peut voir deux variables : login et reset
La variable login permet de savoir si l’utilisateur essaie de faire une réservation ou non, tandis que reset permet de savoir si c’est la première fois que l’utilisateur entre sur la page pour éviter d’ajouter deux fois la réservation d’un utilisateur dans la base de données.
