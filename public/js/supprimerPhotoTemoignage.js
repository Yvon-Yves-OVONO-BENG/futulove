	
	//je sélectionne tous les boutons ayant la classe : "supprimerPhoto"
	const buttons = document.querySelectorAll('.supprimerPhoto');
	
	//je parcours mes boutons
	buttons.forEach(function(button) 
	{
		button.addEventListener('click', function() 
		{
			var photoId = this.dataset.photoId;

			console.log(photoId);
			///je cree un nouvel objet XMLHttpRequest
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '/futulove/public/temoignage/supprimer-photo-temoignage', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function() 
			{
				if (xhr.readyState === 4 && xhr.status === 200) 
				{
					var response = JSON.parse(xhr.responseText);
					
					if (response.success) 
					{			
						notif({
							msg: "<b>Photo supprimée avec succès !</b>",
							type: "success",
							position: "left",
							width: 500,
							height: 60,
							autohide: true
						});
					
					}
					else 
					{
						notif({
							msg: "<b>Erreur lors de la suppression de la photo !</b>",
							type: "danger",
							position: "left",
							width: 500,
							height: 60,
							autohide: true
							});
					}
				}
			};
			
			//j'envoie la request avec le photo ID
			xhr.send('photoTemoignage_id=' + photoId);
		});
		
	});

	

	