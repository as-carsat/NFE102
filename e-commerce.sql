-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 31 jan. 2020 à 23:54
-- Version du serveur :  10.1.32-MariaDB
-- Version de PHP :  5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `test_nfe102`
--

-- --------------------------------------------------------

--
-- Structure de la table `administration`
--

CREATE TABLE `administration` (
  `id_admin` int(10) NOT NULL,
  `username` varchar(250) COLLATE utf8_bin NOT NULL,
  `password` varchar(250) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `administration`
--

INSERT INTO `administration` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `Categorie`
--

CREATE TABLE `Categorie` (
  `id_categorie` int(10) UNSIGNED NOT NULL,
  `libelle_categorie` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  `ordre_affichage` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `Categorisation`
--

CREATE TABLE `Categorisation` (
  `id_categorie` int(10) UNSIGNED NOT NULL,
  `id_produit` int(10) UNSIGNED NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `Clients`
--

CREATE TABLE `Clients` (
  `id_client` int(10) UNSIGNED NOT NULL,
  `id_pays` int(10) UNSIGNED NOT NULL,
  `nom` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `prenom` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `adr1` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `adr2` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `adr3` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `adr4` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `cp` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `ville` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `email` varchar(250) COLLATE utf8_bin NOT NULL,
  `password` varchar(250) COLLATE utf8_bin NOT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `Clients`
--

INSERT INTO `Clients` (`id_client`, `id_pays`, `nom`, `prenom`, `adr1`, `adr2`, `adr3`, `adr4`, `cp`, `ville`, `date_creation`, `email`, `password`, `isdeleted`) VALUES
(7, 14, 'cda', 'dca', 'dca', 'cda', 'a', '', '59290', 'Roubaix', '0000-00-00 00:00:00', 'caad@c.c', 'zz', 0),
(8, 15, 'r', 'r', 'r', 'r', 'r', '', '59290', 'Roubaix', '0000-00-00 00:00:00', 'caad@c.c', 'r', 0),
(9, 16, 'f', 'f', 'f', 'f', 'f', '', '23', 'fr', '2020-01-17 00:01:56', 'f@f.f', 'f', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Commande`
--

CREATE TABLE `Commande` (
  `id_commande` int(10) UNSIGNED NOT NULL,
  `id_client` int(10) UNSIGNED NOT NULL,
  `montant` float DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  `date_traitement` datetime DEFAULT NULL,
  `nb_article` int(10) UNSIGNED DEFAULT NULL,
  `acheve` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `Detail_commande`
--

CREATE TABLE `Detail_commande` (
  `id_detail_commande` int(10) UNSIGNED NOT NULL,
  `id_commande` int(10) UNSIGNED NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  `CA` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `MVT_produit`
--

CREATE TABLE `MVT_produit` (
  `id_mvt_produit` int(10) UNSIGNED NOT NULL,
  `id_detail_commande` int(10) UNSIGNED NOT NULL,
  `id_type_mvt_produit` int(10) UNSIGNED NOT NULL,
  `id_produit` int(10) UNSIGNED NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `Paiement`
--

CREATE TABLE `Paiement` (
  `id_paiement` int(10) UNSIGNED NOT NULL,
  `id_type_paiement` int(10) UNSIGNED NOT NULL,
  `id_commande` int(10) UNSIGNED NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  `date_validation` datetime DEFAULT NULL,
  `code_validation` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `Pays`
--

CREATE TABLE `Pays` (
  `id_pays` int(10) UNSIGNED NOT NULL,
  `libelle_pays` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `Pays`
--

INSERT INTO `Pays` (`id_pays`, `libelle_pays`, `date_creation`, `isdeleted`) VALUES
(14, 'Boeesnie', '0000-00-00 00:00:00', 0),
(15, 'Bsnie', '0000-00-00 00:00:00', 0),
(16, 'fr', '2020-01-17 00:01:56', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Prix`
--

CREATE TABLE `Prix` (
  `id_prix` int(10) UNSIGNED NOT NULL,
  `id_produit` int(10) UNSIGNED NOT NULL,
  `prix` float DEFAULT NULL,
  `date_debut_validite` datetime DEFAULT NULL,
  `DATETIMEfin_validite` datetime DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `Prix`
--

INSERT INTO `Prix` (`id_prix`, `id_produit`, `prix`, `date_debut_validite`, `DATETIMEfin_validite`, `date_creation`, `isdeleted`) VALUES
(1, 1, 25, '2020-01-01 00:00:00', '2020-01-31 00:00:00', '2020-01-09 00:00:00', 0),
(2, 2, 30, '2020-01-01 00:00:00', '2020-01-31 00:00:00', '2020-01-09 00:00:00', 0),
(3, 7, 380, '2020-01-31 23:42:44', '2021-01-31 23:42:44', '2020-01-31 23:42:44', 0),
(4, 9, 235, '2020-01-31 23:48:52', '2021-01-31 23:48:52', '2020-01-31 23:48:52', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Produits`
--

CREATE TABLE `Produits` (
  `id_produit` int(10) UNSIGNED NOT NULL,
  `id_type_produit` int(10) UNSIGNED NOT NULL,
  `libelle_produit` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `titre_produit` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `libelle_court` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `libelle_long` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  `chemin_photo` varchar(60) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `Produits`
--

INSERT INTO `Produits` (`id_produit`, `id_type_produit`, `libelle_produit`, `date_creation`, `titre_produit`, `libelle_court`, `libelle_long`, `isdeleted`, `chemin_photo`) VALUES
(1, 1, 'samsung', '2019-12-03 00:00:00', 'telephone', 'sam', 'samsung', 0, 'admin/img/samsung.jpg'),
(2, 2, 'msi', '2019-12-03 00:00:00', 'ordinateur portable', 'msi', 'msi xfr', 0, 'admin/img/msi.jpg'),
(7, 2, 'Lenovo10', '2020-01-31 23:42:07', 'informatique', '', 'pc de gamer Lenovo', 0, 'admin/img/Lenovo10.jpg'),
(9, 1, 'humai', '2020-01-31 23:48:52', 'téléphonie', 'cher mais bien', 'humai telephone pas cher mais bien', 0, 'admin/img/humai.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `Type_mvt_produit`
--

CREATE TABLE `Type_mvt_produit` (
  `id_type_mvt_produit` int(10) UNSIGNED NOT NULL,
  `libelle_type_mvt_produit` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `Type_paiement`
--

CREATE TABLE `Type_paiement` (
  `id_type_paiement` int(10) UNSIGNED NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  `libelle` varchar(60) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `Type_produit`
--

CREATE TABLE `Type_produit` (
  `id_type_produit` int(10) UNSIGNED NOT NULL,
  `libelle_type_produit` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `Type_produit`
--

INSERT INTO `Type_produit` (`id_type_produit`, `libelle_type_produit`, `date_creation`, `isdeleted`) VALUES
(1, 'téléphonie', '2019-12-03 00:00:00', 0),
(2, 'informatique', '2019-12-03 00:00:00', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administration`
--
ALTER TABLE `administration`
  ADD PRIMARY KEY (`id_admin`);

--
-- Index pour la table `Categorie`
--
ALTER TABLE `Categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `Categorisation`
--
ALTER TABLE `Categorisation`
  ADD PRIMARY KEY (`id_categorie`,`id_produit`),
  ADD KEY `Categorisation_FK1` (`id_categorie`),
  ADD KEY `Categorisation_FK2` (`id_produit`);

--
-- Index pour la table `Clients`
--
ALTER TABLE `Clients`
  ADD PRIMARY KEY (`id_client`),
  ADD KEY `Clients_FK1` (`id_pays`);

--
-- Index pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `Commande_FK1` (`id_client`);

--
-- Index pour la table `Detail_commande`
--
ALTER TABLE `Detail_commande`
  ADD PRIMARY KEY (`id_detail_commande`),
  ADD KEY `Detail_commande_FK1` (`id_commande`);

--
-- Index pour la table `MVT_produit`
--
ALTER TABLE `MVT_produit`
  ADD PRIMARY KEY (`id_mvt_produit`),
  ADD KEY `MVT_produit_FK1` (`id_detail_commande`),
  ADD KEY `MVT_produit_FK2` (`id_type_mvt_produit`),
  ADD KEY `MVT_produit_FK3` (`id_produit`);

--
-- Index pour la table `Paiement`
--
ALTER TABLE `Paiement`
  ADD PRIMARY KEY (`id_paiement`),
  ADD KEY `Paiement_FK1` (`id_type_paiement`),
  ADD KEY `Paiement_FK2` (`id_commande`);

--
-- Index pour la table `Pays`
--
ALTER TABLE `Pays`
  ADD PRIMARY KEY (`id_pays`);

--
-- Index pour la table `Prix`
--
ALTER TABLE `Prix`
  ADD PRIMARY KEY (`id_prix`),
  ADD KEY `Prix_FK1` (`id_produit`);

--
-- Index pour la table `Produits`
--
ALTER TABLE `Produits`
  ADD PRIMARY KEY (`id_produit`),
  ADD KEY `FK1_produits` (`id_type_produit`);

--
-- Index pour la table `Type_mvt_produit`
--
ALTER TABLE `Type_mvt_produit`
  ADD PRIMARY KEY (`id_type_mvt_produit`);

--
-- Index pour la table `Type_paiement`
--
ALTER TABLE `Type_paiement`
  ADD PRIMARY KEY (`id_type_paiement`);

--
-- Index pour la table `Type_produit`
--
ALTER TABLE `Type_produit`
  ADD PRIMARY KEY (`id_type_produit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administration`
--
ALTER TABLE `administration`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Categorie`
--
ALTER TABLE `Categorie`
  MODIFY `id_categorie` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Clients`
--
ALTER TABLE `Clients`
  MODIFY `id_client` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `Commande`
--
ALTER TABLE `Commande`
  MODIFY `id_commande` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Detail_commande`
--
ALTER TABLE `Detail_commande`
  MODIFY `id_detail_commande` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `MVT_produit`
--
ALTER TABLE `MVT_produit`
  MODIFY `id_mvt_produit` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Paiement`
--
ALTER TABLE `Paiement`
  MODIFY `id_paiement` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Pays`
--
ALTER TABLE `Pays`
  MODIFY `id_pays` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `Prix`
--
ALTER TABLE `Prix`
  MODIFY `id_prix` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Produits`
--
ALTER TABLE `Produits`
  MODIFY `id_produit` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `Type_mvt_produit`
--
ALTER TABLE `Type_mvt_produit`
  MODIFY `id_type_mvt_produit` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Type_paiement`
--
ALTER TABLE `Type_paiement`
  MODIFY `id_type_paiement` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Type_produit`
--
ALTER TABLE `Type_produit`
  MODIFY `id_type_produit` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Categorisation`
--
ALTER TABLE `Categorisation`
  ADD CONSTRAINT `categorisation_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `Categorie` (`id_categorie`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `categorisation_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `Produits` (`id_produit`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Clients`
--
ALTER TABLE `Clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `Pays` (`id_pays`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `Clients` (`id_client`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Detail_commande`
--
ALTER TABLE `Detail_commande`
  ADD CONSTRAINT `detail_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `Commande` (`id_commande`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `MVT_produit`
--
ALTER TABLE `MVT_produit`
  ADD CONSTRAINT `mvt_produit_ibfk_1` FOREIGN KEY (`id_detail_commande`) REFERENCES `Detail_commande` (`id_detail_commande`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `mvt_produit_ibfk_2` FOREIGN KEY (`id_type_mvt_produit`) REFERENCES `Type_mvt_produit` (`id_type_mvt_produit`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `mvt_produit_ibfk_3` FOREIGN KEY (`id_produit`) REFERENCES `Produits` (`id_produit`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Paiement`
--
ALTER TABLE `Paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`id_type_paiement`) REFERENCES `Type_paiement` (`id_type_paiement`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `paiement_ibfk_2` FOREIGN KEY (`id_commande`) REFERENCES `Commande` (`id_commande`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Prix`
--
ALTER TABLE `Prix`
  ADD CONSTRAINT `prix_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `Produits` (`id_produit`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Produits`
--
ALTER TABLE `Produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`id_type_produit`) REFERENCES `Type_produit` (`id_type_produit`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
