--
-- Structure de la table `plum_mvc_exemple`
--

CREATE TABLE IF NOT EXISTS `webservice_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lib` varchar(50) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='table exemple de plum.mvc';

--
-- Contenu de la table `plum_mvc_exemple`
--

INSERT INTO `webservice_test` (`id`, `lib`) VALUES
(1, 'Agnès'),
(2, 'Thierry'),
(3, 'Simon'),
(4, 'Claude'),
(5, 'Charles'),
(6, 'Alain'),
(7, 'Clara'),
(8, 'Valérie');
