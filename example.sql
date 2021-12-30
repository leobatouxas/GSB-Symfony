INSERT INTO `employee_type` (`id`, `name`) VALUES
	(1, 'Visiteur'),
	(2, 'Comptable');
	(3, 'Admin');

INSERT INTO `employee` (`id`, `employee_type_id`, `username`, `roles`, `password`, `firstname`, `lastname`, `city`, `postalcode`) VALUES
	(1, 1, 'JohnDoe', '["ROLE_VISITOR"]', '$2y$13$gf76uI.eSomJAEvYbSFkB.H3YIDfQQhGSWdBSA7AjDjnzxUnRil6u', 'John', 'Doe', 'Aubusson', '23200'),
	(2, 2, 'JaneDoe', '["ROLE_ACCOUNTANT"]', '$2y$13$gf76uI.eSomJAEvYbSFkB.H3YIDfQQhGSWdBSA7AjDjnzxUnRil6u', 'Jane', 'Doe', 'Aubusson', '23200'),
	(3, 3, 'Admin', '["ROLE_ADMIN"]', '$2y$13$gf76uI.eSomJAEvYbSFkB.H3YIDfQQhGSWdBSA7AjDjnzxUnRil6u', 'Admin', 'Admin', 'Aubusson', '23200');
	
INSERT INTO `standard_fees` (`id`, `name`, `unit_amount`) VALUES
	(1, 'Nuitée', 80),
	(2, 'Repas Midi', 29),
	(3, 'Kilométrage', 2);
	
INSERT INTO `state` (`id`, `name`) VALUES
	(1, 'Créée'),
	(2, 'Clôturée'),
	(3, 'Validée'),
	(4, 'Mise en paiement'),
	(5, 'Remboursée');

INSERT INTO `fee_sheet` (`id`, `state_id`, `employee_id`, `date`, `nb_documents`, `valid_amount`) VALUES
	(1, 4, 1, '2021-10-01', 5, 218),
	(2, 3, 1, '2021-11-01', 2, 651);
	(3, 1, 1, '2021-12-01', 0, 0);

INSERT INTO `standard_fees_line` (`id`, `standard_fees_id`, `fee_sheet_id`, `quantity`) VALUES
	(1, 1, 1, 1),
	(2, 2, 1, 4),
	(3, 3, 1, 8),
	(4, 1, 2, 4),
	(5, 2, 2, 6),
	(6, 3, 2, 56);

INSERT INTO `variable_fees_line` (`id`, `fee_sheet_id`, `name`, `date`, `amount`) VALUES
	(1, 1, 'Frais 1', '2021-10-12', 6),
	(2, 2, 'REFUSE : Frais 1', '2021-03-28', 15),
	(3, 2, 'Frais 2', '2021-10-06', 45);
