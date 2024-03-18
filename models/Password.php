<?php

class Password extends Model {

public function isPassword($mail, $password) {
  $sql = 'SELECT mdp,type_, nom, prenom, id_promotion FROM utilisateur WHERE mail = :mail';
  $stmt = $this->conn->prepare($sql);
  $stmt->execute(['mail' => $mail]); //permet de bind values
  $data = $stmt->fetch(); 
  
  $passwordHashed = hash('sha256', $password);
  // Vérifiez si un mot de passe a été récupéré et comparez-le
  if ($data && $passwordHashed == $data['mdp']) {  //utilisée pour vérifier si le mot de passe fourni par l'utilisateur correspond au hash du mot de passe stocké dans la base de données
      // Si le mot de passe correspond
      parent::sendJSON(['success' => true, 'type_' => $data['type_'],
      'nom' => $data['nom'],
      'prenom' => $data['prenom'],
      'id_promotion' => $data['id_promotion']]) ;
  } else {
      // Si le mot de passe ne correspond pas ou l'utilisateur n'existe pas
      parent::sendJSON(['success' => false]);
  }
}

}
