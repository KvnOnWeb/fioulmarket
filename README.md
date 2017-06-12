# Fioulmarket
Exercice pour fioulmarket.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/018643f7-f772-44e8-a922-e1f6a7657b09/small.png)](https://insight.sensiolabs.com/projects/018643f7-f772-44e8-a922-e1f6a7657b09)

## 1. Objectifs et détails

Le projet a été fait avec pour objectif d'avoir un modèle de données évolutif tout en conservant de bonnes performances lors de l'import.

Il est décomposé en deux bundles :
- PriceBundle : contient la plupart de l'exercice (modèles de données, commandes et controller API).
- CommonBundle : contient les parties communes à tout projet développer. L'idée est d'avoir une base commune pour les retours des API. Il est très important d'avoir des API uniformisées. 

## 2. Bundles externes

- FosRestBundle : Utilisé pour faciliter les controller de l'API
- NelmioApiDoc : Utilisé pour documenter l'API
- Json-schema-bundle : Utilisé pour la validation des données aux formats JSON

## 3. Utilisations

Suite à l'installation du projet et l'execution du composer install vous pouvez créer un dossier "var/" à la racine et y déposer votre fichier CSV d'import.

- Commande d'import : `php app/console import:csv nom_du_fichier.csv` avec comme option
    - Les options : `--details` utilise la progressBar symfony (détails de l'avancement et consommation mémoire).
    
/!\ Dans un souci de performances bien executer la commande en mode 'prod' sinon la mémoire explose avec le debug activé. /!\
