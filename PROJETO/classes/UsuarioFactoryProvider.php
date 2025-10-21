<?php
require_once 'SolicitanteFactory.php';
require_once 'PrestadorFactory.php';

class UsuarioFactoryProvider {
    
    /**
     *
     * @param string $tipoUsuario The type of user ('solicitante' or 'prestador')
     * @return UsuarioFactory The appropriate factory instance
     * @throws InvalidArgumentException if user type is invalid
     * 
     */
    
    public static function getFactory($tipoUsuario) {
        switch (strtolower($tipoUsuario)) {
            case 'solicitante':
                return new SolicitanteFactory();
                
            case 'prestador':
                return new PrestadorFactory();
                
            default:
                throw new InvalidArgumentException(
                    "Tipo de usuário inválido: " . $tipoUsuario . 
                    ". Use 'solicitante' ou 'prestador'."
                );
        }
    }
}
?>