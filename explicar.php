<?php
    function doSomething($id){
        
        $pdo= conecta();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $motivo= "probar"; 
        $res=0;
        $e="";

        try{
            $pdo->beginTransaction();

            $sql= "INSERT INTO registro (nombre_c, desc_c, motivo_c) (SELECT nombre_a, desc_a, :motivo FROM autos WHERE id=:id)";
            $stmt= $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':motivo', $motivo,PDO::PARAM_STR);
            $res1 = $stmt->execute();
            
            $sql="DELETE FROM autos WHERE id=:id";
            $stmt= $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $res2 = $stmt->execute();

            $pdo->commit();
            $res=$res1&&$res2;
        }catch(PDOException $e){
            $pdo->rollBack();
        }

        unset($stmt);
        unset($pdo);
        return array($res?"actualizado":"error", $e);

    }

?>