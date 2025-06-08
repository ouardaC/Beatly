-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 08 juin 2025 à 04:13
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `beatly`
--

-- --------------------------------------------------------

--
-- Structure de la table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `artist` varchar(100) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `spotify_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `albums`
--

INSERT INTO `albums` (`id`, `title`, `artist`, `genre`, `year`, `description`, `spotify_link`, `youtube_link`, `image_url`, `user_id`, `created_at`) VALUES
(4, 'Dall', 'ARTMS', 'Kpop', 2024, 'DALL est bien plus qu’un premier album : c’est une déclaration, une plongée intense dans l’univers audacieux et novateur d’ARTMS. Composé d’anciennes membres de LOONA, le groupe dévoile ici une palette sonore riche, mêlant électropop expérimentale et pop avant-gardiste, qui capte à la fois l’énergie brute et la finesse émotionnelle. Chaque morceau, de “Virtual Angel” à “Butterfly Effect”, est une invitation à explorer des mondes intérieurs profonds, portés par des mélodies hypnotiques et des rythmes captivants. DALL est un voyage vibrant, où audace et sensibilité s’entrelacent, affirmant ARTMS comme une force créative incontournable dans la K-pop moderne.', 'https://open.spotify.com/album/0hJloArA2Kb9xNBIv34osS', 'https://www.youtube.com/watch?v=7gP0Tk3-fJU&t=4s', 'assets/img/artms.jpg', 9, '2025-06-07 14:08:15'),
(5, 'MEGA BBL', 'THEODORA', 'Variété française', 2020, 'MEGA BBL, la réédition de Bad Boy Lovestory sortie en mai 2025, révèle toute la richesse musicale de Theodora. Avec 25 titres mêlant bouyon, afrobeat, hyperpop, rap français et drum and bass, l’album fait la part belle aux collaborations, notamment avec Juliette Armanet et Chilly Gonzales. De “PAPA” à la version live de “Ils me rient tous au nez”, cet opus confirme Theodora comme une artiste audacieuse et incontournable de la scène française.', 'https://open.spotify.com/intl-fr/album/5kULRFcbbkP6NHNBpi6T6p?si=KnrRaiXnQeSryjpmdBL3mA', 'https://www.youtube.com/watch?v=Ot_caZAA0hQ&list=OLAK5uy_nr1_9SEzUrGJVts7RxMotVXUnSY50nqX4', 'assets/img/theodora.jpg', 9, '2025-06-07 15:40:52'),
(8, 'Trampoline', 'Satine', 'Variété française', 2025, 'Ancienne membre des Kids United, Satine prend son envol en solo avec un premier EP puissant et personnel, sorti en 2025. Entre pop moderne et émotions à fleur de peau, elle signe un projet affirmé qui commence fort avec “Enemie”, et se termine sur la poésie mélancolique de “Contemplation”. Coup de cœur assuré pour “Le monde est à nous”, ode lumineuse à la liberté et à l’émancipation.\r\nUn début solo qui ne laisse pas indifférent.', 'https://open.spotify.com/intl-fr/album/3QIL5b9o8459ZGTIQsOZwx?si=a41ECln6QRuENZ5csTgeHQ', 'https://youtu.be/BYtviIHwWFI', 'assets/img/Trampoline-satine.jpg', 9, '2025-06-07 22:15:09'),
(9, 'Crash', 'Charlie XCX', 'Pop', 2022, 'Crash, cinquième album de Charli XCX, est un véritable tourbillon électro-pop qui allie énergie brute et mélodies accrocheuses. Avec ce projet, Charli repousse les limites de la pop moderne en mixant des sonorités audacieuses et des productions hyper travaillées, tout en gardant son instinct pop intact. Chaque titre est pensé pour la piste de danse, mais sans jamais sacrifier l’émotion ou la personnalité. Des morceaux comme “Speed Drive” ou “Used to Know Me” témoignent de sa capacité à allier fun et profondeur. Crash confirme Charli XCX comme une artiste incontournable, qui maîtrise à la perfection l’art de faire vibrer autant les clubs que les cœurs.', 'https://open.spotify.com/intl-fr/album/1QqipMXWzJhr6yfcNKTp8B?si=9Rjqc-bHSKWbjZopREysyg', 'https://youtu.be/mRYb1FHhzEw?si=vqxCj89QQfrVBXu_', 'assets/img/charliexcx-crash.jpg', 9, '2025-06-07 22:35:24'),
(10, 'Brat', 'Charlie XCX', 'Pop', 2024, 'Brat est le sixième album studio de Charli XCX, sorti en juin 2024. Ce projet audacieux mêle hyperpop, electroclash et influences rave des années 2000, offrant une expérience sonore brute et énergique. L&amp;amp;#039;album aborde des thèmes personnels tels que la jalousie, l&amp;amp;#039;anxiété, la vulnérabilité et la rivalité féminine, tout en célébrant la liberté et l&amp;amp;#039;indépendance. Des titres comme “Von Dutch”, “Club Classics”, “360” et “Sympathy is a Knife” illustrent cette exploration sonore et émotionnelle. La collaboration avec Lorde sur “Girl, so confusing” ajoute une dimension supplémentaire à l&amp;amp;#039;album. Avec Brat, Charli XCX confirme son statut d&amp;amp;#039;artiste incontournable, capable de réinventer la pop avec audace et sincérité.', 'https://open.spotify.com/intl-fr/album/2lIZef4lzdvZkiiCzvPKj7?si=EM2PYeNVQueoNX-K0MHhYg', 'https://www.youtube.com/watch?v=bvy6aox2Sgw&list=PL-2HG0C5jJQE-D-1odtlA47fbP7oCg62e', 'assets/img/charliexcx-Brat.jpg', 9, '2025-06-07 22:40:37'),
(11, 'Le Monde ou Rien', 'PNL', 'Rap', 2015, 'Le Monde ou Rien, sorti en 2015, est l’album qui a définitivement établi PNL comme un phénomène incontournable du rap français. Avec un style unique mêlant trap atmosphérique, mélodies aériennes et textes introspectifs, les frères Ademo et N.O.S ont créé une œuvre qui transcende les codes du genre. L’album dépeint la réalité de la vie en banlieue avec une poésie sombre et sincère, entre espoir et fatalisme. Les morceaux phares comme “Le monde ou rien”, “J’suis PNL” ou “Oh lala” ont marqué une génération, grâce à leur capacité à allier émotions brutes et production innovante. Le Monde ou Rien est un voyage immersif, à la fois mélancolique et puissant, qui a renouvelé le rap français en lui offrant une nouvelle profondeur.', 'https://open.spotify.com/intl-fr/album/0OrjrvwmdJ82zYJpJ46lUs?si=QgFlfhmvQXqa34-8G0CmaQ', 'https://www.youtube.com/watch?v=VtQ0odvF6_s&list=PLZ7IFInqxuitE7zruBFRCNJOuIVwN-CkO', 'assets/img/Pnl-lemondeourien.jpg', 9, '2025-06-07 22:46:01'),
(12, 'Deux Frères', 'PNL', 'Rap', 2022, 'Deux Frères de PNL, c’est l’album qui a confirmé que le duo ne fait pas que rapper : ils créent de véritables expériences. Sorti en 2019, ce projet a explosé les compteurs, notamment grâce au clip de “Au DD”, qui a fait un buzz énorme sur internet avec ses images impressionnantes tournées sur la Tour Eiffel. L’album mélange parfaitement sons planants et beats puissants, tout en gardant cette ambiance mélancolique et introspective qui fait la signature du groupe. Des titres comme “À l’ammoniaque”, “Deux frères” ou “Blanka” racontent avec émotion les hauts et bas de leur parcours, la fraternité, la réussite et la dureté de la vie en banlieue. Deux Frères est une œuvre qui a marqué la pop urbaine française, imposant PNL comme des maîtres dans l’art de mêler visuels forts, textes poétiques et production innovante.', 'https://open.spotify.com/intl-fr/track/6hzi3AGB39FjxFqcjgbWs7?si=8f20a571292944d8', 'https://youtu.be/BtyHYIpykN0?si=MuOqNwGGHWQhweQE', 'assets/img/deuxfrere-pnl.jpg', 9, '2025-06-07 22:49:10'),
(13, 'Favorite', 'Yoa', 'Variété française', 2025, 'La Favorite première album de la chanteuse Yoa est une œuvre authentique et ambitieuse, une plongée sincère dans les paradoxes (doute, résilience, féminité, trauma).\r\nLes productions variées et les textes percutants ( 2013, la Favorite ou bien le collectionneur) montrent que Yoa est désormais une voix forte et originale de la pop moderne française, avec un potentiel pour conquérir les grandes scènes (Olympia…) et les cœurs .', 'https://open.spotify.com/intl-fr/album/60cnL4NlNjkEQWRgPYlrmG?si=6U0X2-8VQciUgEa7rRV0ZA', 'https://www.youtube.com/playlist?list=PLSgvPhNapaKjxxJ9XZ06dQQfG9rFp9cOF', 'assets/img/Yoa-favorite.jpg', 9, '2025-06-07 23:06:19'),
(15, 'Artpop', 'Lady Gaga', 'Pop', 2013, 'ARTPOP (2013) est le quatrième album de Lady Gaga et sans doute son chef-dœuvre le plus incompris – un ovni électro-pop maximaliste qui était tout simplement trop en avance sur son temps. Sorti en pleine guerre des charts face au Roar plus consensuel de Katy Perry, lalbum a polarisé à sa sortie avec ses productions saturées et ses concepts avant-gardistes qui semblaient déconnectés du mainstream de lépoque. Pourtant, cest précisément cette radicalité qui en fait aujourdhui un album visionnaire : ses expérimentations sonores délirantes, ses synthés futuristes et son esthétique cyber-pop annoncent déjà lhyperpop et la pop expérimentale des années 2020. Entre GUY et Venus, Gaga livre sa vision la plus pure et non-compromise de lart pop, assumant pleinement lexcès et la théâtralité qui font son génie. Réécouter ARTPOP aujourdhui, cest réaliser quelle avait une décennie davance – c’est son album le plus authentique et visionnaire, celui qui révèle toute létendue de son génie artistique sans filtre commercial.', 'https://open.spotify.com/intl-fr/album/2eRJUtI7nXrQ5uYQ7tzTo9?si=YcMHnbkEQY2Y6HUQZEG5EQ', 'https://www.youtube.com/playlist?list=OLAK5uy_l5rd5P0ngKjGGHxNfHw_VoERFfvFAYSmA', 'assets/img/ladyGaga-artpop.png', 9, '2025-06-07 23:18:09'),
(16, 'Born This Way', 'Lady Gaga', 'Pop', 2011, 'Born This Way marque un tournant majeur dans la carrière de Lady Gaga. C’est un manifeste musical de liberté, dinclusivité et de revendication identitaire. Porté par une énergie brute mêlant électro, rock et influences industrielles, ce disque libère Gaga de limage purement provocatrice pour lui permettre de revendiquer son rôle de leader culturel. Des titres comme Born This Way, Judas ou Marry The Night défient les normes, prônent lamour-propre et célèbrent les marges. Cest un album chargé démotion, de foi et de rage créative, où les sonorités puissantes accompagnent un message politique assumé. Gaga sy montre à la fois vulnérable et combative, fusionnant la pop de stade avec le militantisme queer. Born This Way reste un cri de guerre moderne, exubérant et sincère, qui a redéfini ce que pouvait être une pop star au XXIe siècle.', 'https://open.spotify.com/album/6LY3AerY6KNGOPsNPL63Kk?si=IA26bOhsSCy3E4zQSC8pxw', 'https://www.youtube.com/playlist?list=OLAK5uy_k25nBF9896qEAU1zoFa3KvMmQqYNS5Y_k', 'assets/img/LadyGaga-btw.jpg', 9, '2025-06-07 23:35:15'),
(17, 'Bad Romance', 'Lady Gaga', 'Pop', 2009, 'Bad Romance, sorti en 2009, est le titre emblématique qui a propulsé Lady Gaga au rang de phénomène mondial. Mélange explosif de pop futuriste, de dance électrisante et d&#039;une touche gothique, ce morceau est une déclaration de style, de pouvoir et de vulnérabilité. Dès les premières notes, avec son intro hypnotique et son cri de guerre Ra ra ah ah ah, Gaga impose un univers singulier, théâtral et troublant. La chanson explore la passion destructrice, les relations toxiques et le désir incontrôlable, avec une intensité dramatique rare dans la pop mainstream. La production est glaciale et percutante, les refrains sont inoubliables, et la voix de Gaga oscille entre douceur et rage. Bad Romance est plus quun hit : cest une œuvre dart pop, une synthèse parfaite de la vision visuelle et sonore de Gaga à son apogée. Un classique instantané qui a redéfini les codes de la pop du XXIe siècle.', 'https://open.spotify.com/album/7j7iPq5rokadGr1ZdJRGgE?si=zn1Zhk8lSOiAYQXHc9XgGQ', 'https://www.youtube.com/watch?v=qhBmrs40QpY&list=PLvIcNJmwjdZkFfjOk3wn2Zclz2O9ZyXr9', 'assets/img/ladyGaga-badromance.jpg', 9, '2025-06-07 23:36:48'),
(18, 'UMLA', 'Alpha Wann', 'Rap', 2018, 'Une main lave lautre de Alpha Wann est un projet dense et parfaitement maîtrisé, souvent considéré comme une référence du rap technique en France. Sur Langage crypté, il enchaîne les phases complexes avec une fluidité impressionnante. Le morceau Stupéfiant et noir impose une ambiance sombre et tendue portée par des punchlines tranchantes. Cascade montre quil peut briller aussi sur des prods plus mélodiques tout en gardant son intensité. Chaque titre est construit avec soin, sans formats radio ni compromis. Cest un album brut, exigeant, qui révèle toute la précision et lintelligence du rappeur.', 'https://open.spotify.com/intl-fr/album/6wXBrJU2DZt5Ga9nUZYXcg?si=ce8683efcf6148f5', 'https://www.youtube.com/watch?v=X4rm5qmSkbM', 'assets/img/alphaWann-UMLA.jpg', 9, '2025-06-07 23:39:18'),
(19, 'Graou', 'Miki', 'Variété française', 2024, 'Graou de Miki est un concentré de pop électro déjantée et ultra personnelle. Sur echec et mat, elle impose un flow brut et percutant sur une prod hyper accrocheuse. Le morceau cartoon sex pousse plus loin son univers entre absurdité et sensualité synthétique. scorpion ascendant scorpion propose une ambiance plus nocturne, presque mystique, avec un refrain entêtant. jtm encore explore une facette plus vulnérable de Miki, toujours portée par des sonorités glitch et sucrées. L EP brille par sa cohérence et son audace, mélangeant douceur enfantine et énergie explosive sans jamais se brider.', 'https://open.spotify.com/intl-fr/album/2BMT7xu97SvpVB20ciDNFW?si=_6x8IFtwQge4T25lWH9DbA', 'https://www.youtube.com/channel/UCE5ERFpACLMvTaTzLsmLVPQ', 'assets/img/Graou-miki.jpg', 9, '2025-06-07 23:58:58'),
(20, '2069', 'PLK', 'Rap', 2024, '2069 de PLK est un projet court mais efficace, qui marque un retour aux bases tout en explorant des sonorités plus futuristes. Le morceau sur le drapeau tape fort avec une instru froide et une écriture percutante, tandis que marbella apporte une vibe plus estivale, plus mélodique. PLK jongle entre égotrip maîtrisé et introspection discrète, sans jamais perdre en flow. La prod de chaque titre est soignée, avec une touche moderne qui colle bien au thème du projet. 2069 confirme son aisance à s’adapter tout en gardant son identité.', 'https://open.spotify.com/intl-fr/album/50UFRkLAkzL731ZFWym4Vq?si=27373a3acc814e6b', 'https://www.youtube.com/playlist?list=OLAK5uy_kgk_OnTlwlHBszOw8XiMFw8oehqQKFxxw', 'assets/img/plk-2069.jpg', 9, '2025-06-08 00:47:49'),
(21, 'Kali Uchis', 'Isolation', 'RnB', 2018, 'Isolation de Kali Uchis est un album solaire et éclectique où elle navigue entre R&amp;B, funk, soul, pop psyché et reggaeton avec une aisance déconcertante. Dès Body Language, elle installe une ambiance sensuelle et planante. After the Storm avec Tyler et Bootsy Collins insuffle une vibe funky irrésistible, tandis que Dead to Me et In My Dreams montrent une facette plus pop et mélancolique. L’album brille par sa cohérence malgré la variété des styles, porté par la voix suave de Kali et une production léchée. Isolation est un voyage intime et groovy, à la fois vintage et avant-gardiste.', 'https://open.spotify.com/intl-fr/album/4EPQtdq6vvwxuYeQTrwDVY?si=94e8468bdfd8425a', 'https://www.youtube.com/playlist?list=OLAK5uy_mDBx9zKmDyvGMR1obcyOGwq-knkpK7ez8', 'assets/img/kalisUchis-Isolation.jpg', 9, '2025-06-08 00:53:30'),
(22, 'Disco', 'kylie minogue', 'Pop', 2020, 'Disco de Kylie Minogue est un hommage brillant et assumé à la musique dance des années 70 et 80, remis au goût du jour avec une touche pop moderne. Des morceaux comme Magic et Say Something débordent d’énergie et de paillettes, avec des refrains catchy taillés pour le dancefloor. Kylie joue à fond la carte de la nostalgie tout en gardant une production propre et actuelle. L’album est cohérent, festif et léger, parfait pour s’évader dans un univers disco glamour. Un retour en force pour une icône qui maîtrise toujours l’art de faire danser.', 'https://open.spotify.com/intl-fr/album/140JX9hRDcAmfANQeKSnmG?si=rsDjIjEkRoKGSrSLJn0G3g', 'https://www.youtube.com/watch?v=dF4yuBOg44A&list=PLzbGLskt3hhmvnu_k9ASDFr0bb_cKQdpC', 'assets/img/kylieMinogue-disco.jpg', 9, '2025-06-08 00:55:15'),
(23, 'My everything', 'Ariana Grande', 'Pop', 2015, 'My Everything marque la montée en puissance d’Ariana Grande comme star pop mondiale. L’album oscille entre RnB aérien et bangers électro-pop efficaces, avec des hits comme Problem, Break Free ou encore Love Me Harder. Sa voix impressionne par sa maîtrise vocale, souvent comparée à celle de Mariah Carey, tout en affirmant sa propre identité. Moins uniforme que ses albums suivants, My Everything montre une artiste en transition, entre influences soul et volonté de conquérir les charts.', 'https://open.spotify.com/intl-fr/album/6dYDqMHA4COCFC0TfCiUCj?si=vAhnxMAfTn2kNzcjo8_cJA', 'https://www.youtube.com/playlist?list=OLAK5uy_lcAQW0bAGPBo6D-NxZt37-Zh7DPfQb96g', 'assets/img/arianaGrande-myeverything.jpg', 9, '2025-06-08 00:57:17'),
(24, 'Sweetener', 'Ariana Grande', 'Pop', 2018, 'Avec Sweetener, Ariana Grande prend un virage artistique audacieux. Produit en grande partie par Pharrell Williams, l’album mêle pop, trap et RnB alternatif sur des titres comme Blazed ou The Light Is Coming. God is a Woman et No Tears Left to Cry apportent un équilibre plus grand public, tout en montrant une maturité nouvelle. C’est un disque à la fois intime et expérimental, où Ariana explore la guérison, l’amour et la résilience avec douceur et innovation.', 'https://open.spotify.com/album/3tx8gQqWbGwqIGZHqDNrGe?si=5Q0bN9vFTOK5iuao0p5xVw', 'https://www.youtube.com/playlist?list=OLAK5uy_kvi6xfWSkfUFjGtPHjvxuOcNsdnIlSUr8', 'assets/img/arianaGrande-Sweetener.jpg', 9, '2025-06-08 00:58:43'),
(25, 'Love Therapy', 'Monsieur Nov', 'RnB', 2024, 'Love Therapy de Monsieur Nov explore avec finesse les blessures du cœur, sur fond de RnB intimiste et mélancolique. L’album enchaîne des titres forts comme T’es où, Dernier je taime ou encore Elle m’a aimé, chacun porté par une écriture vulnérable et une voix toujours maîtrisée. Les prods, souvent minimalistes, laissent toute la place à l’émotion brute. Un projet sincère, à la fois doux et poignant, qui confirme le talent unique de Nov pour parler d’amour sans filtre.', 'https://open.spotify.com/intl-fr/album/5a5C4f2S7NvcMCdwQFqT48?si=cYtXJ7q7TJGNw0ZlkSBCUw', 'https://www.youtube.com/watch?v=2SSUliYlho8&list=RD2SSUliYlho8&start_radio=1', 'assets/img/MonsieurNov-Love-Therapy.jpg', 9, '2025-06-08 01:03:36'),
(26, '130 mood Trbl', 'Dean', 'Korean Rnb', 2016, '130 mood TRBL de DEAN est un mini-album coréen aussi sensuel qu expérimental, mêlant RnB alternatif, soul et touches électroniques avec une maîtrise rare. Des morceaux comme Pour Up avec Zico ou D Half Moon avec Gaeko dévoilent un univers nocturne, mélancolique et sophistiqué. La voix de DEAN, à la fois douce et déchirante, traverse chaque instru avec fluidité. En seulement quelques titres, il impose une signature sonore unique, à la fois moderne et émotionnelle, qui a marqué un tournant dans la scène RnB coréenne.', 'https://open.spotify.com/intl-fr/album/1MW3txTS49ZGvyLi0fziLU?si=7970f94c293640b1', 'https://www.youtube.com/playlist?list=OLAK5uy_nF3pW60THeSSuC-IdFfQh2wautFpKWRSo', 'assets/img/130-Mood-Trbl.jpg', 9, '2025-06-08 01:05:58'),
(27, 'TAP', 'Taeyong', 'Kpop', 2024, 'TAP de Taeyong est un mini-album abouti et varié, marqué par des instrus accrocheuses, un flow affirmé, et une voix plus vulnérable. Les morceaux secondaires comme Moon Tour, Run Away, APE sont souvent cités comme plus forts que le titre principal. c’est un projet équilibré, mêlant modernité, émotion brute, et identité personnelle forte.', 'https://open.spotify.com/intl-fr/album/5PliHwqYkEzdXHZnA6scC0?si=v_4DqzkVTM6KpbF19p_Hdg', 'https://www.youtube.com/watch?v=vjGIY_GyAz4&list=OLAK5uy_mTsev-wsIVQpQ3-cOhSQqEsiehA8dn4fo', 'assets/img/Taeyoung-TAP.jpg', 9, '2025-06-08 01:09:39'),
(28, 'In a Dream', 'Troye Sivan', 'Pop', 2020, 'Troye Sivan livre avec In A Dream un EP court mais dense, rempli d’émotions éclatées et de pop synthétique élégante. C’est une rupture amoureuse racontée à travers des sons audacieux et instables, entre mélancolie et euphorie. Easy brille par sa sincérité et sa mélodie lumineuse, tandis que STUD explore le désir et l’insécurité avec une tension électro remarquable. Le morceau final, In A Dream, clôt le projet avec une montée intense, presque cathartique. C’est un projet concis, intime, et très stylisé, qui montre un Troye plus expérimental et vulnérable.', 'https://open.spotify.com/intl-fr/album/6DutwGzMeny33G6mIpujDj?si=sowuss4aQlKqiiDckAJGMw', 'https://www.youtube.com/watch?v=MYMn7joQTwM&list=PLUbWhnfHu1fWWtoO0vmprMHt-HLQw87O7', 'assets/img/In-A-Dream-Edition-Deluxe.jpg', 9, '2025-06-08 01:11:58'),
(29, 'Piece of Mind', 'Iron Maiden', 'Heavy Metal', 1983, 'The Trooper est un classique du heavy metal, porté par un riff galopant devenu légendaire. Inspiré par la bataille de Balaclava, le morceau mêle énergie brute, virtuosité technique et imagerie guerrière. La voix perçante de Bruce Dickinson, la batterie rapide et les duels de guitares donnent une intensité presque épique. C est un hymne puissant, à la fois narratif et explosif, qui incarne parfaitement l esprit d Iron Maiden.', 'https://open.spotify.com/album/7I9Wh2IgvI3Nnr8Z1ZSWby?si=K14rPWjNSly-TDjbdDCpnw', 'https://www.youtube.com/watch?v=dAcH-q2O8eY', 'assets/img/album_99a09c02b57e9d09d7b1ffe3ebdb37b43272eaa5.jpg', 9, '2025-06-08 01:17:17'),
(30, 'short n sweet', 'Sabrina Carpenter', 'Pop', 2024, 'Short n Sweet est une pop malicieuse et pleine d’assurance. Avec sa production rétro et ses lignes de synthé accrocheuses, Sabrina Carpenter livre un morceau taquin et mordant. L’album du même nom s’annonce riche en pépites : Taste séduit par son groove sensuel, Please Please Please touche par sa vulnérabilité, et Lie to Girls, peut-être le plus marquant, mélange émotion brute et mélodie douce-amère. Un projet aussi pétillant que touchant, où chaque titre affirme un peu plus la signature unique de Sabrina.', 'https://open.spotify.com/intl-fr/album/3iPSVi54hsacKKl1xIR2eH?si=SttvBl6XTxuobfr9b__Ciw', 'https://www.youtube.com/playlist?list=OLAK5uy_mr6DjxLeVO2rPk8zAZx0F2_k5BaGuXlyQ', 'assets/img/SabrinaCarpenter-shortandsweets.jpg', 9, '2025-06-08 01:41:36'),
(31, 'Sensitive', 'Loossemble', 'Kpop', 2023, 'Sensitive est un bijou de pop coréenne délicate et élégante. Le morceau mélange une prod aérienne, des voix cristallines et une vibe légèrement RnB qui donne envie de flotter. Loossemble y montre une vraie cohésion vocale et une identité raffinée. D’autres titres de l’album comme Real World ou Strawberry Soda prolongent cette ambiance douce et rêveuse, tout en affirmant un style qui se détache du girly pop classique. Un projet à la fois sensible et maîtrisé.', 'https://open.spotify.com/intl-fr/album/51TyZNm7E9EF1gSJGLGsxh?si=y8WdNBFYSMm85rJr6uP_Kg', 'https://www.youtube.com/watch?v=yytpG5cND5A', 'assets/img/album_13f51d55292e2d45bbda95140e1baa3463731139.jpg', 9, '2025-06-08 01:47:08'),
(32, 'Cosmic', 'Red Velvet', 'Kpop', 2024, 'Pour leur dernier retour en OT5, Red Velvet signe avec Cosmic un album à la fois élégant, sombre et envoûtant. Inspirée par l esthétique de Midsommar, la title track mêle mystère et sensualité dans une ambiance florale et troublante. Les b-sides comme Sunflower, Last Drop ou Night Drive offrent un voyage sonore riche en émotions et textures. C est un projet maîtrisé de bout en bout, qui montre à quel point le groupe continue d évoluer avec maturité et ambition.', 'https://open.spotify.com/intl-fr/album/5E8apoFsaUFhZxGGSju6aW?si=AL0ilXGoTDinYvXeo0VRQw', 'https://www.youtube.com/watch?v=46FxItq18h0&list=PLBxlGtcUp1gnGyqJduvv9sbAE9PokF4Mf', 'assets/img/RedVelvet-cosmic.jpg', 9, '2025-06-08 01:56:00'),
(33, 'Dumb Dumb', 'Red Velvet', 'Kpop', 2015, 'The Red est un concentré d’énergie pop débordante et d’attitudes audacieuses. L’album explore plusieurs facettes : l’électro-pop percutante avec Dumb Dumb, le RnB smooth sur Campfire, et la balade émotive avec Oh Boy. Sur dix morceaux, Red Velvet brille par ses harmonies vocales, ses refrains imparables et ses productions dynamiques, qui ont solidement établi leur identité dans l’univers K‑pop. The Red reste un jalon musical puissant qui ont marqué le début des filles.', 'https://open.spotify.com/intl-fr/album/6YL9J0E6PGtYzkhyMxnmXd?si=VC_paEWHSvuH3baVDahFwg', 'https://www.youtube.com/playlist?list=OLAK5uy_lkJLiuU3Jx3ODAIY-VljxhUesPs5w8fZ4', 'assets/img/RedVelvet-DumbDumb.jpg', 9, '2025-06-08 01:58:57');

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_album_review` (`user_id`,`album_id`),
  KEY `album_id` (`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `album_id`, `rating`, `comment`, `created_at`) VALUES
(5, 9, 4, 5, 'wow super !!!', '2025-06-07 14:08:34'),
(6, 9, 5, 3, 'incroyable', '2025-06-07 15:41:00'),
(7, 11, 5, 5, 'FASHION DESIGNER OUH OUH OUHHH J\'achete plus je designeuhhhh', '2025-06-07 17:40:23'),
(9, 11, 4, 5, 'Troppppppp hâte de les voir en concert', '2025-06-07 17:52:46'),
(11, 9, 15, 4, 'mon son fav c\'est swine !', '2025-06-07 23:31:00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `profile_picture`, `created_at`) VALUES
(9, 'CHOERRY33', 'dualipa@gmail.com', '$2y$10$zCCgK3im0QQHgRfElsm7cuFdt5fExU7hs5GVxZ5Kpnh7JXjf3qCyi', 'admin', '68443de60eda8.jpg', '2025-06-07 13:14:43'),
(10, 'heejin11', 'heejin11@gmail.com', '$2y$10$7MegUIACjL18lKTA/988nOUDe.QkUaYwkrR8W4NZbDXAfUNhgIlMy', 'user', '684443445b511.jpg', '2025-06-07 13:48:52'),
(11, 'jinsoul22', 'jinsoul22@gmail.com', '$2y$10$/ULOGNxNMKFOf384aPcxyelTZ0pqzyrniuFRlhMcVM3yn.lW1hEvW', 'user', '68447c4081b86.png', '2025-06-07 17:36:18');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
