# Règles de contribution au projet

Toute personne souhaitant contribuer au site web de La Forge des Joueurs est 
invitée à le faire ! Pour ce faire, il suffit de suivre les règles définies dans ce document.

La première étape du voyage consiste à aller piocher une [issue GitHub](https://github.com/LFDJ-35/Project-web/issues) ou d'en créer une.

## Workflow

1. Choisir une issue sur laquelle travailler (voir [Fonctionnement des issues](#fonctionnement-des-issues))
2. Proposer une solution au problème et en discuter avec les contributeurs
3. Partir de la branche `main` (`git switch main`), puis créer une branche avec un nom explicite (`git switch -c ma_fonctionnalite`), voir [Règles des branches](#règles-des-branches)
4. Réaliser le développement
5. Demander une Pull Request (PR) afin que le code à ajouter dans la branche principale soit relu par les différents contributeurs
6. Si votre PR est acceptée, l'issue peut être close.

## Fonctionnement des issues

Les issues sont un espace de disscussion pour implémenter de nouvelles fonctionnalités. Avant d'essayer d'implémenter une fonctionnalité à l'aveuglette, il est nécessaire de discuter de la fonctionnalité, de poser le cas d'usage et de converger vers une solution technique avant de proposer une implémentation dans une branche.

Les schémas explicatifs sont les bienvenus dans la discussion d'une issue !

## Règles des branches

### Nommage des branches

Les branches doivent être nommées de manière explicite et refléter le développement réalisé dans celle-ci.

| ✅ Branche conforme       | 🚫 Branche non conforme |
| ------------------------- | ----------------------- |
| improve_responsive_design | j4aimelesfraises        |
| feature/trombi            | ma_branche              |
| fix/bug_carte             | test                    |

### Une branche = Une issue

Afin d'être **acceptée en pull request**, une branche doit correspondre à une issue. Il est possible de créer des issues pour une fonctionnalité que vous souhaitez voir apparaître sur le site.

Segmenter les branches en issues permet de rendre la modification atomique et de faciliter la relecture.
