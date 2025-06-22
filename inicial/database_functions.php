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

    // Buscar nome dos funcionários por ID com cache
    private function buscarNomeFuncionario($pdo, $id, &$cache) {
        if (!isset($cache[$id])) {
            $stmt = $pdo->prepare("SELECT nome FROM funcionarios WHERE id = ?");
            $stmt->execute([$id]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $cache[$id] = $resultado ? $resultado['nome'] : 'Funcionário não encontrado';
        }
        return $cache[$id];
    }

    // Buscar dados das solicitações (com nome)
    public function getSolicitacoes() {
        $pdoSolic = $this->connect('solicitacoes');
        $pdoFunc = $this->connect('semestral');

        $sql = "SELECT id, data_escolhida, opcao FROM dados ORDER BY data_escolhida DESC";
        $stmt = $pdoSolic->prepare($sql);
        $stmt->execute();
        $solicitacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cacheNomes = [];
        foreach ($solicitacoes as &$sol) {
            $sol['nome'] = $this->buscarNomeFuncionario($pdoFunc, $sol['id'], $cacheNomes);
        }

        return $solicitacoes;
    }

    // Buscar dados das justificativas (com nome)
    public function getJustificativas() {
        $pdoJust = $this->connect('justificativas');
        $pdoFunc = $this->connect('semestral');

        $sql = "SELECT id, data_escolhida, opcao FROM justificativas ORDER BY data_escolhida DESC";
        $stmt = $pdoJust->prepare($sql);
        $stmt->execute();
        $justificativas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cacheNomes = [];
        foreach ($justificativas as &$just) {
            $just['nome'] = $this->buscarNomeFuncionario($pdoFunc, $just['id'], $cacheNomes);
        }

        return $justificativas;
    }

    // Contar total de solicitações
    public function getTotalSolicitacoes() {
        $pdo = $this->connect('solicitacoes');
        $sql = "SELECT COUNT(*) as total FROM dados";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Contar total de justificativas
    public function getTotalJustificativas() {
        $pdo = $this->connect('justificativas');
        $sql = "SELECT COUNT(*) as total FROM justificativas";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Buscar dados recentes (últimos registros de solicitações)
    public function getRecentSolicitacoes($limit = 2) {
        $pdo = $this->connect('solicitacoes');
        $sql = "SELECT id, data_escolhida, opcao FROM dados ORDER BY data_escolhida DESC LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar dados recentes (últimos registros de justificativas)
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
    public static function formatarData($data) {
        $timestamp = strtotime($data);
        return date('d/m', $timestamp);
    }

    public static function formatarDataCompleta($data) {
        $timestamp = strtotime($data);
        return date('d/m/Y', $timestamp);
    }

    public static function escapeHtml($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    public static function formatarNumero($numero, $digitos = 2) {
        return sprintf('%0' . $digitos . 'd', $numero);
    }
}
?>
