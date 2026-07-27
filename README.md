# Script oral — Soutenance APSA (15 min + 5 min démo)

> Chronométrage indicatif total : **≈ 15 min de parole** sur les slides + **5 min de démonstration live** = 20 min. Entraîne-toi à voix haute avec un chrono une fois pour ajuster ton propre débit — ces durées sont pensées pour un rythme normal, ni précipité ni traînant.

---

### Slide 1 — Titre (~35 sec)
> "Bonjour à tous. Nous allons vous présenter APSA, Static Application Security Analyzer — un outil d'analyse de sécurité statique que nous avons conçu et développé cette année. En une phrase : APSA détecte des vulnérabilités de sécurité directement dans le code source, avant même que ce code soit exécuté. Je suis [prénom], et voici [prénom], mon binôme sur ce projet."

---

### Slide 2 — Sommaire (~30 sec)
> "Voici comment on va dérouler cette présentation. On commence par le contexte et le besoin auquel on répond, puis on explique l'architecture et le fonctionnement global d'APSA. On zoomera ensuite sur les modules techniques les plus intéressants. On fera une démonstration en direct d'un scan complet. Et on terminera par un bilan de ce qui a été réalisé, ce qu'on améliorerait, et les perspectives."

---

### Slide 3 — Contexte & problématique (~55 sec)
> "Pourquoi ce projet ? Une injection SQL, un `eval()` dynamique, ou une clé API codée en dur dans le code peuvent très bien passer inaperçus lors d'une revue de code classique — et être découverts seulement une fois exploités en production. C'est le premier problème : la détection est souvent trop tardive.
>
> Le deuxième problème, c'est l'offre existante : les outils les plus complets, comme Snyk ou GitHub Advanced Security, envoient le code vers un service cloud tiers, avec un coût à l'usage. Et les alternatives gratuites — Bandit, Semgrep, Trivy — sont chacune spécialisées sur une seule brique. Pour un audit complet, il faut en assembler plusieurs."

---

### Slide 4 — Notre réponse / objectifs (~55 sec)
> "Notre réponse : un outil auto-hébergé qui réunit dans une seule base de code ce qui est habituellement dispersé. APSA analyse le code Python, JavaScript et PHP par arbre de syntaxe abstraite pour limiter les faux positifs. Il détecte aussi les secrets codés en dur, et les CVE connues dans les dépendances. Et il enrichit chaque résultat par intelligence artificielle — explication et correctif.
>
> Quatre piliers, donc : le multi-langages, la sécurité renforcée avec secrets et CVE, l'IA augmentée, et une double interface — ligne de commande et interface web — pour couvrir aussi bien un usage développeur qu'un usage autonome."

---

### Slide 5 — État de l'art (~60 sec)
> "On ne réinvente pas la roue en ignorant ce qui existe. On a comparé APSA aux références du marché. Bandit fait de l'AST natif mais uniquement sur Python. Semgrep couvre énormément de langages mais demande une configuration assez lourde. Snyk Code unifie SAST et SCA, avec de l'IA — mais c'est une solution cloud commerciale, où le code est envoyé à un tiers. Trivy est excellent sur les CVE et les conteneurs, mais ne fait aucune analyse du code source applicatif lui-même.
>
> Notre positionnement, c'est de réunir ces trois briques — SAST multi-langages, SCA, et IA — dans un seul outil qu'on héberge nous-mêmes, sans jamais transférer le code vers un service tiers."

---

### Slide 6 — Architecture générale (~65 sec)
> "Voici l'architecture technique, en quatre couches indépendantes. En haut, les interfaces : une CLI construite avec Typer, et une interface web en Flask. En dessous, le cœur du système, dans le dossier `core` — c'est lui qui orchestre tout : le scoring, la génération de rapports, le dédoublonnage, la détection de secrets, l'analyse de dépendances, et l'intelligence artificielle.
>
> Encore en dessous, les parsers : un par langage. Python utilise le module `ast` natif de Python. JavaScript et PHP délèguent l'analyse à un sous-processus — Node.js pour l'un, PHP en ligne de commande pour l'autre — qui communique en JSON.
>
> Et enfin, tout en bas, les services externes : OSV.dev pour vérifier les CVE, et l'API Google Gemini pour l'intelligence artificielle.
>
> Le point important à retenir : le cœur ne sait jamais parser du code lui-même. Il ne manipule qu'un objet commun, une `Vulnerability`, peu importe d'où elle vient."

---

### Slide 7 — Structure du projet (~45 sec)
> "Concrètement, voici comment ça se traduit dans l'arborescence du code. Le dossier `core` contient dix modules, chacun avec une responsabilité unique — le scoring, les rapports, la détection de secrets, l'analyse SCA, l'IA... Le dossier `parsers` contient les trois moteurs de langage. Le dossier `templates` contient l'interface web. Et le dossier `tests` contient notre suite de tests unitaires, qu'on a maintenue tout au long du projet à chaque nouvelle fonctionnalité ajoutée."

---

### Slide 8 — Trajet d'un scan (~65 sec)
> "Concrètement, que se passe-t-il quand on lance un scan ? Six étapes. D'abord, la découverte : on liste récursivement tous les fichiers `.py`, `.js`, `.php` du dossier ciblé. Ensuite, le routage : chaque fichier part vers le parser de son langage — AST pour Python, sous-processus pour JS et PHP.
>
> En parallèle, chaque fichier est aussi passé au scanner de secrets, et si on trouve un `requirements.txt` ou un `package.json`, le module SCA interroge OSV.dev. Ensuite, on nettoie les résultats : on supprime les doublons, puis on filtre les lignes explicitement ignorées par le développeur. En option, l'intelligence artificielle vient enrichir chaque résultat. Et enfin, on calcule un score de A à F, et on génère le rapport — en HTML, en Markdown, ou directement dans l'interface web."

---

### Slide 9 — Zoom module 1/4 : analyse statique par AST (~60 sec)
> "Premier zoom technique : pourquoi l'arbre de syntaxe abstraite plutôt qu'une simple recherche de mot-clé ? Prenez cet exemple : un `eval()` caché derrière un commentaire `apsa-ignore`, une injection SQL par concaténation. Un simple `grep` sur le mot `eval` matcherait aussi bien un commentaire ou une chaîne de caractères qui contiendrait ce mot par hasard.
>
> L'AST, lui, représente la structure réelle du programme après analyse syntaxique. On sait qu'on est face à un appel de fonction réel, dans du code exécutable — pas dans un commentaire. Ça réduit fortement les faux positifs. Pour Python, on utilise le module `ast` natif. Pour JavaScript et PHP, qui n'ont pas cet équivalent en Python, on délègue à l'écosystème natif de chaque langage."

---

### Slide 10 — Zoom module 2/4 : sécurité renforcée (~55 sec)
> "Deuxième zoom : au-delà du code lui-même. Premièrement, la détection de secrets — des signatures structurelles indépendantes du langage : une clé AWS, un token GitHub, une clé Google, un bloc de clé privée PEM. Ça s'applique à chaque fichier scanné, quel que soit son langage, parce qu'un secret codé en dur a la même forme partout.
>
> Deuxièmement, l'analyse de composition logicielle, le SCA : on parse les fichiers `requirements.txt` et `package.json`, puis on interroge l'API publique OSV.dev pour savoir si une dépendance déclarée a une CVE connue. On a préféré s'appuyer sur une base ouverte et déjà maintenue plutôt que de recréer notre propre base de vulnérabilités."

---

### Slide 11 — Zoom module 3/4 : réduction du bruit (~55 sec)
> "Troisième zoom : comment on réduit le bruit et les faux positifs. D'abord, le dédoublonnage automatique — deux findings strictement identiques, même fichier, même ligne, même règle, ne sont comptés qu'une fois.
>
> Ensuite, un mécanisme qu'on a appelé `apsa-ignore` : un développeur peut ajouter ce marqueur en commentaire, en fin de ligne, pour dire explicitement au scanner d'ignorer un finding précis — soit toute la ligne, soit seulement une règle ciblée si plusieurs findings tombent au même endroit. Ça marche quel que soit le style de commentaire du langage, parce qu'on cherche simplement ce texte dans la ligne brute, peu importe la syntaxe."

---

### Slide 12 — Zoom module 4/4 : intelligence artificielle (~60 sec)
> "Quatrième et dernier zoom : l'intelligence artificielle, avec deux modes bien distincts. Le premier mode enrichit une vulnérabilité déjà détectée par une règle : l'IA fournit une explication en langage naturel, et un correctif de code concret. Le risque d'erreur est limité, puisqu'elle n'enrichit qu'un résultat déjà confirmé.
>
> Le deuxième mode, qu'on appelle la recherche approfondie, va plus loin : l'IA relit le fichier entier pour trouver des failles logiques que les règles statiques ne peuvent pas voir par construction — un contrôle d'accès manquant, une IDOR. Ces pistes-là sont consignées à part, pour être revues par un administrateur avant d'éventuellement devenir une nouvelle règle du scanner — elles ne sont jamais montrées telles quelles à l'utilisateur final."

---

### Slide 13 — Restitution : scoring & rapports (~45 sec)
> "Une fois l'analyse terminée, on synthétise tout ça en un score de criticité de 0 à 100, pondéré par sévérité, et résumé en un grade de A à F — simple à lire en un coup d'œil. Les résultats sont exportables en HTML ou en Markdown, prêts à être partagés ou archivés. Et l'interface web garde un historique des scans, propre à chaque session utilisateur."

---

### Slide 14 — Exploitation : interface web & déploiement (~45 sec)
> "Côté exploitation, deux points qu'on tenait à soigner particulièrement. D'abord, l'historique fonctionne sans compte utilisateur : chaque visiteur reçoit un identifiant de session aléatoire, stocké dans un cookie signé, ce qui isole les scans de chacun sans mot de passe à gérer.
>
> Ensuite, la clé API n'est jamais exposée : elle n'est jamais dans le code, jamais dans le dépôt Git. Elle est lue depuis une variable d'environnement, uniquement côté serveur, injectée au démarrage du service. Le formulaire web ne la demande jamais à l'utilisateur."

---

### Slide 15 — Transition démonstration (~20 sec, puis 5 min de démo live)
> "Plutôt que de continuer à vous décrire l'outil, on va vous le montrer directement. On va scanner un petit projet de démonstration qui contient volontairement : un `eval()` en Python, une clé AWS codée en dur, une dépendance avec une CVE connue, et une ligne marquée `apsa-ignore` — pour vous montrer les quatre mécanismes qu'on vient de présenter, en un seul scan."

*(Bascule vers le terminal / navigateur — 5 minutes de démo. Garde un œil sur l'heure : si tu dépasses, coupe avant la fin du scan SCA plutôt que sur l'explication IA, qui est plus parlante pour le jury.)*

---

### Slide 16 — Bilan planning (~50 sec)
> "Revenons maintenant sur la gestion du projet. Le cahier des charges initial estimait la charge à 83 heures, sur cinq grandes phases : fondations, module Python, modules JavaScript et PHP, moteur de scoring, tests et documentation. Ce périmètre a été respecté dans les délais.
>
> Une fois ce socle terminé, on a fait le choix d'étendre le projet au-delà du périmètre initial : interface web, sécurité renforcée avec secrets et SCA, intelligence artificielle, et mise en production réelle. Au total, la charge réelle est montée à 117 heures, réparties sur neuf phases, avec une suite de 40 tests unitaires maintenue tout du long."

---

### Slide 17 — Rétrospective : bilan & limites (~55 sec)
> "Qu'est-ce qui s'est bien passé ? Techniquement, l'architecture en couches nous a permis d'ajouter facilement de nouveaux modules — secrets, SCA, IA — sans jamais casser l'existant. Côté gestion de projet, on a avancé de façon itérative, chaque fonctionnalité étant testée avant d'attaquer la suivante.
>
> Qu'est-ce qu'on améliorerait ? Techniquement, notre détection reste basée sur des règles et des signatures : une vraie analyse de flux de données réduirait encore les faux positifs. Et côté gestion de projet, le périmètre a été élargi de façon assez informelle en cours de route — formaliser ces extensions plus tôt, dans un cahier des charges mis à jour, aurait facilité le suivi."

---

### Slide 18 — Perspectives (~45 sec)
> "Pour la suite, plusieurs pistes sont identifiées. Une analyse par flux de données, pour aller au-delà des règles statiques. Un export au format SARIF, pour s'intégrer nativement aux pull requests GitHub et GitLab. Le support de langages supplémentaires, comme TypeScript ou Java. Une authentification pour un usage multi-équipe sur l'interface web. Et enfin, une intégration continue, avec une GitHub Action qui lancerait le scan automatiquement sur chaque pull request."

---

### Slide 19 — Merci / Questions (~15 sec)
> "Voilà pour notre présentation. Merci de votre attention — on est prêts à répondre à vos questions."

---

## Récapitulatif du minutage

| Slides | Durée cumulée |
|---|---|
| 1 → 8 (intro, contexte, archi, fonctionnement) | ≈ 6 min 30 |
| 9 → 14 (zooms techniques + restitution + exploitation) | ≈ 5 min 45 |
| 15 (transition + démo live) | 20 sec + **5 min de démo** |
| 16 → 19 (bilan, rétrospective, perspectives, merci) | ≈ 2 min 45 |
| **Total slides** | **≈ 15 min** |
| **Total avec démo** | **≈ 20 min** |

## Conseils pour la répétition
- Chronomètre-toi une première fois en lisant tel quel : ajuste ensuite selon ton propre débit naturel (ce script est calibré sur un rythme normal, pas précipité).
- Les slides 6, 8 et 9 sont les plus denses techniquement — ce sont celles où tu risques de déraper sur le temps. Entraîne-toi en priorité dessus.
- Prévois un point de repli si la démo prend du retard : mieux vaut couper avant le scan SCA (qui dépend du réseau, donc plus imprévisible) que de sacrifier la conclusion.
- Le jury coupe souvent la parole pour poser une question en cours de route — ne panique pas si tu n'arrives pas exactement à la seconde près sur chaque slide, l'important est la structure globale.
