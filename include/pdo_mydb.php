<?php
//This class comes from Feng . Fox
//Modified: lovoner@gmail.com
//Refer to: http://blog.csdn.net/fenglailea/article/details/15335575

/**错误函数 Feng.Fox
 * @param $e 对象
 * @param bool $debug
 * @param string $message 错误信息
 * @param string $sql 错误sQL
 * @return bool
 */
function halt($e, $debug=true,$message = '', $sql = '') {
 	if ($debug) {
 		if (isset ( $e->errorInfo )) {
 			$errorInfo = $e->errorInfo;
 			$errorno = $e->getCode ();
 			$error = $e->getMessage ();
 			$errorFile = $e->getFile ();
 			$errorLine = $e->getLiNe ();
 		} elseif($e->getCode()) {
            $errorLine= $e->getLine();
 			$errorno = $e->getCode();
 			$error = $e->getMessage();
 			$errorFile = $e->getFile();
 		} else {
            $errorInfo = $e->errorInfo();
            $errorno = $errorInfo [1];
            $error = $errorInfo [2];
            $errorFile = '';
        }
 		$errormsg = "<b>MySQL Query : </b> $sql <br /><b> MySQL Error : </b>{$error} <br /> <b>";
        $errormsg .= "MySQL Errno : </b>{$errorno} <br /><b>";
        $errormsg .= "File : </b>{$errorFile} <br /><b>";
        $errormsg .= "Line : </b>{$errorLine} <br /><b> Message : </b> $message <br />";
 		echo $errormsg;
 		exit ();
 	} else {
 		return false;
 	}
}

/**
 * 对字段两边加反引号，以保证数据库安全
 * @param $value 数组值
 * @return string
 */
function add_special_char($value)    {
	if ('*' == $value || false !== strpos($value, '(') || false !== strpos($value, '.') || false !== strpos($value, '`')) {
		//不处理包含* 或者 使用了sql方法。
	} else {
		$value = '`' . trim($value) . '`';
	}
	if (preg_match('/\b(select|insert|update|delete)\b/i', $value)) {
		$value = preg_replace('/\b(select|insert|update|delete)\b/i', '', $value);
	}
	return $value;
}

//==============================
//PDO::Statement
//==============================
final class CPDOStatement
{
    public  $debug = false;
    public  $pdo = null;
    private $st = null;

    /**
     * @param $st
     * @param $pdo
     */
    public function CPDOStatement($st, $pdo) {
        $this->st = $st;
        $this->pdo = $pdo;
    }

    /**
     * @param array $input_parameters
     * @return $this|bool
     */
    public function execute(array $input_parameters = null)
    {
        try {
            $this->st->execute($input_parameters);
            return $this;
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /**
     * 输出1行数据
     * @param int $fetch_style
     * @return array
     */
    public function fetch($fetch_style = PDO::FETCH_ASSOC)
    {
        try {
            return $this->st->fetch($fetch_style);
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /**
     * @param $parameter
     * @param $variable
     * @param null $data_type
     * @param null $length
     * @param null $driver_options
     * @return $this|bool
     */
    public function bindParam($parameter, &$variable, $data_type = null, $length = null, $driver_options = null)
    {
        try {
            $this->st->bindParam($parameter, $variable, $data_type, $length, $driver_options);
            return $this;
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /**
     * @param $column
     * @param $param
     * @param null $type
     * @param null $maxlen
     * @param null $driverdata
     * @return $this|bool
     */
    public function bindColumn($column, &$param, $type = null, $maxlen = null, $driverdata = null)
    {
        try {
            $this->st->bindColumn($column, $param, $type, $maxlen, $driverdata);
            return $this;
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /**
     * 绑定参数
     *
     * @param string $parameter 字符参数[:num]或数字（从1开始）;根据prepare中的SQL语句
     * @param string $value 数据
     * @param int $data_type 其他
     * @return boolean
     */
    public function bindValue($parameter, $value, $data_type = null)
    {
        try {
            $this->st->bindValue($parameter, $value, $data_type);
            return $this;
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /**
     * 总记录数
     * @return int
     */
    public function rowCount()
    {
        return $this->st->rowCount();
    }

    /**
     * 获取第一行的某列，默认第1列
     * @param int $column_number 从0开始
     * @return boolean
     */
    public function fetchColumn($column_number = null)
    {
        try {
            return $this->st->fetchColumn($column_number);
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /**
     * 输出全部数据
     * @param $fetch_style
     * @return array
     */
    public function fetchAll($fetch_style = PDO::FETCH_ASSOC)
    {
        try {
            return $this->st->fetchAll($fetch_style);
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /**
     * @param null $class_name
     * @param array $ctor_args
     * @return bool
     */
    public function fetchObject($class_name = null, array $ctor_args = null)
    {
        try {
            return $this->st->fetchObject($class_name, $ctor_args);
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function errorCode()
    {
        return $this->st->errorCode();
    }

    /**
     * @return mixed
     */
    public function errorInfo()
    {
        return $this->st->errorInfo();
    }

    /**
     * @param $attribute
     * @param $value
     * @return $this|bool
     */
    public function setAttribute($attribute, $value)
    {
        try {
            $this->st->setAttribute($attribute, $value);
            return $this;
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /**
     * @param $attribute
     * @return $this|bool
     */
    public function getAttribute($attribute)
    {
        try {
            $this->st->getAttribute($attribute);
            return $this;
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /*
     * 结果集列数
    */
    public function columnCount()
    {
        return $this->st->columnCount();
    }

    /**
     * @param $column
     * @return $this|bool
     */
    public function getColumnMeta($column)
    {
        try {
            $this->st->getColumnMeta($column);
            return $this;
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /**
     * @param $mode
     * @return $this|bool
     */
    public function setFetchMode($mode)
    {
        try {
            $this->st->setFetchMode($mode);
            return $this;
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function nextRowset()
    {
        return $this->st->nextRowset();
    }

    /**
     * @return mixed
     */
    public function closeCursor()
    {
        return $this->st->closeCursor();//Refer to: http://www.php.net/manual/zh/pdostatement.closecursor.php
    }

    /**
     * @return mixed
     */
    public function debugDumpParams()
    {
        return $this->st->debugDumpParams();
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->closeCursor();
    }
}

//==============================
//CPDO
//==============================
final class CPDO {
    private $config = null;//array()
    private $pdo = null;
	private $debug = false;

    /**
     *
     * @param  	$config = array('host' => DB_CONN_HOST, 
                 	'port' => '3306',
                 	'dbname' 	=> DB_CONN_NAME, 
                 	'username' => DB_CONN_USER, 
                 	'password' => DB_CONN_PSWD, 
                 	'options'=>array( 	PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
				 						PDO::ATTR_PERSISTENT => true,
										PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
								)
                 ); 
     * @return void
     */
    public function __construct($config=array()) {
        $this->config = $config;
    }

    /**
     * @return void
     */
    public function connect()    {
        try {
            if (empty ($this->config ['dsn'])) {
                $dsn = "mysql:host=".$this->config['host'].";dbname=".$this->config['dbname'].";port=".$this->config ['port'];
            } else {
                $dsn = $this->config ['dsn'];
            }
            $this->pdo = new PDO ($dsn, $this->config ['username'], $this->config ['password'], $this->config ['options']);
            $this->database = $this->config ['dbname'];
            return true;
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }
	
    /*
     * 标明回滚起始点
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    /*
     * 标明回滚结束点，并执行SQL
     */
    public function commit()
    {
        return $this->pdo->commit();
    }

    /*
     * 获取错误码
     */
    public function errorCode()
    {
        return $this->pdo->errorCode();
    }

    /*
     * 获取错误的信息
     */
    public function errorInfo()
    {
        return $this->pdo->errorInfo();
    }

    /*
     * 处理一条SQL语句，并返回所影响的条目数
     */
    public function mydb_exec($sql)
    {
        try {
            return $this->pdo->exec($sql);
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /*
     * 获取一个"数据库连接对象"的属性
     */
    public function getAttribute($attribute)
    {
        try {
            return $this->pdo->getAttribute($attribute);
        } catch (PDOException $e) {
            return false;
        }
    }

    /*
     * 获取有效的PDO驱动器名称
     */
    public function getAvailableDrivers()
    {
        return $this->pdo->getAvailableDrivers();
    }

    /*
     * 获取写入的最后一条数据的主键值
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * 处理一条SQL语句 返回结果集
     *
     * @param string $sql
     * @return array
     */
    public function mydb_query($sql)
    {	
	
        try {
            return $this->pdo->query($sql);

        } catch (PDOException $e) {
			
            halt($e, $this->debug); 
			return false;
        }
    }

    /**
     * 生成一个"查询对象"
     *
     * @param string $sql
     *            查询语句
     * @return object
     */
    public function prepare($sql)
    {
        try {
            return new CPDOStatement ($this->pdo->prepare($sql), $this->pdo);
        } catch (PDOException $e) {
            halt($e, $this->debug);
            return false;
        }
    }

    /*
     * 为某个SQL中的字符串添加引号 public function quote(){ }
     */
    /*
     * 执行回滚
     */
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

    /*
     * 为一个"数据库连接对象"设定属性
     */
    public function setAttribute($attribute, $value)
    {
        try {
            $this->pdo->setAttribute($attribute, $value);
            return $this;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        $this->pdo = null;
    }
}
?>