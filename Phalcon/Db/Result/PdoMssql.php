<?php

namespace Phalcon\Db\Result;

use Phalcon\Db\Adapter\Pdo\Mssql;
/**
 * Phalcon\Db\Result\PdoSqlsrv
 * Encapsulates the resultset internals
 * <code>
 * $result = $connection->query("SELECT * FROM robots ORDER BY name");
 * $result->setFetchMode(Phalcon\Db::FETCH_NUM);
 * while ($robot = $result->fetchArray()) {
 * print_r($robot);
 * }
 * </code>.
 */
class PdoMssql extends Pdo
{
    /**
     * Gets number of rows returned by a resultset
     * <code>
     * $result = $connection->query("SELECT * FROM robots ORDER BY name");
     * echo 'There are ', $result->numRows(), ' rows in the resultset';
     * </code>.
     *
     * @return int
     */
    public function numRows()
    {
        $rowCount = $this->_rowCount;
        if ($rowCount === false) {
            $rowCount = $this->_pdoStatement->rowCount();
            
            // Some MSSQL drivers will return -1 instead of the rowcount so we will execute an extra statement here
            if ($rowCount === -1 && substr($this->_sqlStatement, 0, 6) == 'SELECT') {
                $conn = new Mssql($this->_connection->_descriptor);
                $res = $conn->query('SELECT COUNT(*) OVER() AS numrows,' . substr($this->_sqlStatement, 6), $this->_bindParams, $this->_bindTypes);
                $row = $res->_pdoStatement->fetch();
                if (!empty($row)) {
                    $rowCount = $row['numrows'];
                }
            }
            
            if ($rowCount === false) {
                parent::numRows();
            }

            $this->_rowCount = $rowCount;
        }

        return $rowCount;
    }
}
