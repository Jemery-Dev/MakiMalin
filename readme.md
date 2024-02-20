# MakiMalin - Liste des Courses Symfony

Ce projet a été réalisé dans le cadre du TP Noté 2023 - Symfony – BUT 2 pour Alexis MONNET by OnylRocks. 

## Lancement du Projet

Pour lancer le projet MakiMalin, suivez ces étapes :

1. Assurez-vous d'avoir [PHP](https://www.php.net/) et [Composer](https://getcomposer.org/) installés sur votre système.

2. Clonez ce dépôt Git en utilisant la commande suivante :
   ```
   git clone <url-du-repo.git>
   ```

3. Accédez au répertoire du projet :
   ```
   cd MakiMalin
   ```

4. Installez les dépendances en exécutant :
   ```
   composer install
   ```

5. Configurez votre serveur web pour pointer vers le répertoire `public/` du projet.

6. Assurez-vous que votre serveur web (comme Apache ou Nginx) est correctement configuré pour prendre en charge Symfony. 

7. Assurez-vous que les permissions des répertoires `var/` et `public/uploads/` sont correctement configurées pour que Symfony puisse écrire dans ces répertoires.

8. Configurez votre fichier `.env` avec les paramètres nécessaires, notamment la connexion à la base de données.

9. Créez la base de données en utilisant la commande Symfony :
   ```
   php bin/console doctrine:database:create
   ```

10. Appliquez les migrations pour créer le schéma de la base de données :
   ```
   php bin/console doctrine:migrations:migrate
   ```

11. Enfin, vous pouvez accéder à l'application dans votre navigateur en vous rendant sur l'URL correspondante.

## Auteur

Ce projet a été développé par [Girard Jérémy]

