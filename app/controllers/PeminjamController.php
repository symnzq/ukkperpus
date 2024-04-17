<?php 
use Dompdf\Dompdf;
class PeminjamController extends Controller
{
  public function __construct()
  {
    /**
      * Batasi hak akses hanya untuk Administrator dan Petugas
      * Selain Administrator dan Petugas akan langsung diarahkan kembali ke halaman home
    */
    if ($_SESSION['role'] !== 'Administrator' && $_SESSION['role'] !== 'Petugas') {
      redirectTo('error', 'Mohon maaf, Anda tidak berhak mengakses halaman ini', '/');
    }
  }

  public function index()
  {
    $data = $this->model('Peminjaman')->get();
    $this->view('peminjam/home', $data);
  }

  public function cetakpeminjam()
  {
    $data = $this->model('Peminjaman')->get();
    $html = "<center>";
    $html .= "<h1>SMK MERDEKA BANDUNG</h1>";
    $html .= "<h2>PERPUSTAKAAN DIGITAL</h2>";
    $html .= "<h3>DAFTAR PEMINJAM</h3>";
    $html .= "<hr>";
    $html .= "<table align='center' border='1' cellpadding='10' cellspacing='0'>";
    $html .= "<tr><th>#</th><th>NamaLengkap</th><th>Alamat</th><th>Judul</th><th>TanggalPengembalian</th><th>Status</th></tr>";
    $no = 1;
    foreach ($data as $k ) {
      $html .= "<tr>";
      $html .= "<td>" . $no . "</td>";
      $html .= "<td>" .$k['NamaLengkap'] . "</td>";
      $html .= "<td>" .$k['Alamat'] . "</td>";
      $html .= "<td>" .$k['Judul'] . "</td>";
      $html .= "<td>" . $k['TanggalPengembalian'] . "</td>";
      $html .= "<td>" .$k['StatusPeminjaman'] . "</td>";
      $html .= "</tr>";
      $no++;
    }
    $html .= "</table>";
    $html .= "</center>";
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('4A', 'potrait');
    $dompdf->render();
    $dompdf->stream('Data Buku', ['Attachment' => 0]);
  }
}
