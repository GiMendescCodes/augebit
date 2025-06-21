<?php
// database_functions.php
class DatabaseManager {
    private $host;
    private $username;
    private $password;
    
    public function __construct($host = 'localhost', $username = 'root', $password = '') {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }
    
    // Conectar ao banco de dados
    private function connect($database) {
        try {
            $pdo = new PDO("mysql:host={$this->host};dbname=$database;charset=utf8", $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch(PDOException $e) {
            throw new Exception("Erro na conexão com banco $database: " . $e->getMessage());
        }
    }
    
    // Buscar dados das solicitações (tabela 'dados')
    public function getSolicitacoes() {
        $pdo = $this->connect('solicitacoes');
        $sql = "SELECT id, data_escolhida, opcao FROM dados ORDER BY data_escolhida DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Contar total de solicitações
    public function getTotalSolicitacoes() {
        $pdo = $this->connect('solicitacoes');
        $sql = "SELECT COUNT(*) as total FROM dados";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    // Buscar dados das justificativas
    public function getJustificativas() {
        $pdo = $this->connect('justificativas');
        $sql = "SELECT id, data_escolhida, opcao FROM justificativas ORDER BY data_escolhida DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Contar total de justificativas
    public function getTotalJustificativas() {
        $pdo = $this->connect('justificativas');
        $sql = "SELECT COUNT(*) as total FROM justificativas";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    // Buscar dados recentes (últimos registros)
    public function getRecentSolicitacoes($limit = 2) {
        $pdo = $this->connect('solicitacoes');
        $sql = "SELECT id, data_escolhida, opcao FROM dados ORDER BY data_escolhida DESC LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRecentJustificativas($limit = 2) {
        $pdo = $this->connect('justificativas');
        $sql = "SELECT id, data_escolhida, opcao FROM justificativas ORDER BY data_escolhida DESC LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Funções auxiliares
class HelperFunctions {
    // Formatar data para exibição
    public static function formatarData($data) {
        $timestamp = strtotime($data);
        return date('d/m', $timestamp);
    }
    
    // Formatar data completa
    public static function formatarDataCompleta($data) {
        $timestamp = strtotime($data);
        return date('d/m/Y', $timestamp);
    }
    
    // Escapar HTML para segurança
    public static function escapeHtml($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    // Formatar número com zeros à esquerda
    public static function formatarNumero($numero, $digitos = 2) {
        return sprintf('%0' . $digitos . 'd', $numero);
    }
}

// Exemplo de uso da classe
/*
try {
    $db = new DatabaseManager('localhost', 'seu_usuario', 'sua_senha');
    
    $solicitacoes = $db->getSolicitacoes();
    $total_solicitacoes = $db->getTotalSolicitacoes();
    
    $justificativas = $db->getJustificativas();
    $total_justificativas = $db->getTotalJustificativas();
    
    echo "Total de solicitações: " . $total_solicitacoes;
    echo "Total de justificativas: " . $total_justificativas;
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
*/
?>