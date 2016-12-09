<?php
namespace Library\FormFields;

class FileField extends \Library\Field
{
	public function buildWidget()
	{
		$widget = '';
		
		$widget .= '<div class="form-group" id="'.$this->name.'" /><label>'.$this->label.'</label><br />';
		
		if (!empty($this->errorMessage)) { $widget .= $this->errorMessage.'<br />';}
				
		if (isset($_FILES['mb_avatar'])) // + autres vérifications d'usage pour s'assurer du bon format de l'image
		{
			$pic_name = basename($_FILES['mb_avatar']['name']);
			$pic_url = '../../Applications/Frontend/Modules/Membre/Ressources/Avatars/'.$pic_name;
			
			move_uploaded_file($_FILES['mb_avatar']['tmp_name'], $pic_url);
			
			// echo '<img src="'.$pic_url.'" />'; // afficher l'image par exemple // mais ne marche pas !
			// echo '<br />';
			
			$widget .= '<input type="text" name="'.$this->name.'" value="'.$this->value.'" disabled />';
		}
		else
		{
			// cas où ça vient de la base de données
			if (!empty($this->value)) {
				$widget .= '<div class="avatar-account"><img class="img-thumbnail" src="../../Applications/Frontend/Modules/Membre/Ressources/Avatars/'.htmlspecialchars($this->value).'" /></div><br />';
			}
			
			$widget .= '<input type="file" name="'.$this->name.'" />';
		}
		
		return $widget .= '</div>';		
	}	
}