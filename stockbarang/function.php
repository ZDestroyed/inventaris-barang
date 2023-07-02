<?php
session_start();

$conn = mysqli_connect("localhost","root","","stockbarang_db");


if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    //cek db
    $cekdatabase = mysqli_query($conn, "select * from login where email = '$email' and password='$password'");

    $hitung = mysqli_num_rows($cekdatabase);

    if($hitung>0){
        $ambildatarole = mysqli_fetch_array($cekdatabase);
        $role = $ambildatarole['role'];

        if($role=='admin'){
            $_SESSION['log'] = 'Logged';
            $_SESSION['role'] = 'Admin';
            header('location:adminindex.php');
        }else{
            $_SESSION['log'] = 'Logged';
            $_SESSION['role'] = 'User';
            header('location:index.php');
        }

    }else{
        header('location:login.php');
    };
};



//tambah barang index
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn,"insert into stock (namabarang, deskripsi, stock) values('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index.php');
    }else{
        echo 'gagal';
        header('location:index.php');
    }
};
//tambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahakanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk =mysqli_query($conn,"insert into masuk (idbarang, keterangan, qty) values('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock ='$tambahakanstocksekarangdenganquantity' where idbarang='$barangnya' ");

    if($addtomasuk&&$updatestockmasuk){
        header('location:barangmasuk.php');
    }else{
        echo 'gagal';
        header('location:barangmasuk.php');
    }
};

//tambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahakanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar =mysqli_query($conn,"insert into keluar (idbarang, penerima, qty) values('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock ='$tambahakanstocksekarangdenganquantity' where idbarang='$barangnya' ");

    if($addtokeluar&&$updatestockmasuk){
        header('location:barangkeluar.php');
    }else{
        echo 'gagal';
        header('location:barangkeluar.php');
    }
};

//tambah barang index admin
if(isset($_POST['addnewbarangadmin'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn,"insert into stock (namabarang, deskripsi, stock) values('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:adminindex.php');
    }else{
        echo 'gagal';
        header('location:adminindex.php');
    }
};
//tambah barang masuk admin
if(isset($_POST['barangmasukadmin'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahakanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk =mysqli_query($conn,"insert into masuk (idbarang, keterangan, qty) values('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock ='$tambahakanstocksekarangdenganquantity' where idbarang='$barangnya' ");

    if($addtomasuk&&$updatestockmasuk){
        header('location:adminbarangmasuk.php');
    }else{
        echo 'gagal';
        header('location:adminbarangmasuk.php');
    }
};

//tambah barang keluar admin
if(isset($_POST['addbarangkeluaradmin'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahakanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar =mysqli_query($conn,"insert into keluar (idbarang, penerima, qty) values('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock ='$tambahakanstocksekarangdenganquantity' where idbarang='$barangnya' ");

    if($addtokeluar&&$updatestockmasuk){
        header('location:adminbarangkeluar.php');
    }else{
        echo 'gagal';
        header('location:adminbarangkeluar.php');
    }
};

//update barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang = '$idb'");
    if($update){
        header('location:adminindex.php');
    }else{
        echo 'gagal';
        header('location:adminindex.php');
    }
};

//hapus barang
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn,"delete from stock where idbarang='$idb'");
    if($hapus){
        header('location:adminindex.php');
    }else{
        echo 'gagal';
        header('location:adminindex.php');
    }
};


//mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock Where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn,"select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if($qty>$qtyskrng){
        $selisih = $qty-$qtyskrng;
        $kurangin = $stockskrng + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");

        if($kurangistocknya&&$updatenya){
            header('location:adminbarangmasuk.php');
        }else{
            echo 'gagal';
            header('location:adminbarangmasuk.php');  
        }
    }else{
        $selisih = $qtyskrng-$qty;
        $kurangin = $stockskrng - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty',keterangan='$deskripsi' where idmasuk='$idm'");

        if($kurangistocknya&&$updatenya){
            header('location:barangmasuk.php');
        }else{
            echo 'gagal';
            header('location:barangmasuk.php');  
        }
    }
};

//hapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock-$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from masuk where idmasuk='$idm'");
    if($update&&$hapusdata){
        header('location:adminbarangmasuk.php');
    }else{
        echo 'gagal';
        header('location:adminbarangmasuk.php');
    }
};

//mengubah data barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock Where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn,"select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if($qty>$qtyskrng){
        $selisih = $qty-$qtyskrng;
        $kurangin = $stockskrng - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");

        if($kurangistocknya&&$updatenya){
            header('location:adminbarangkeluar.php');
        }else{
            echo 'gagal';
            header('location:adminbarangkeluar.php');  
        }
    }else{
        $selisih = $qtyskrng-$qty;
        $kurangin = $stockskrng + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");

        if($kurangistocknya&&$updatenya){
            header('location:adminbarangkeluar.php');
        }else{
            echo 'gagal';
            header('location:adminbarangkeluar.php');  
        }
    }
};

//hapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock+$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from keluar where idkeluar='$idk'");
    if($update&&$hapusdata){
        header('location:adminbarangkeluar.php');
    }else{
        echo 'gagal';
        header('location:adminbarangkeluar.php');
    }
};


?>