						<?php
						$filtre = array("En Çok Satılan Ürün", "Toplam Mesailer", "Mesaide En Çok Kazandıran", "Son 1 Haftada En Çok Kazandıran Ürün");
						$sql1 = "SELECT u.id, u.isim, COUNT(u.id) as sayi FROM siparis as s
								 INNER JOIN urunler as u ON u.id = s.u_id
								 GROUP BY u_id
								 ORDER BY sayi DESC";
						$sql2 = "SELECT p.id, p.isim, m.zaman, m.durum FROM mesai as m
								 INNER JOIN personel as p ON p.id = m.p_id";
						$sql3 = "SELECT * FROM siparis";
						$sql4 = "SELECT * FROM urunler";
						$sorgu = array($sql1, $sql2, $sql3, $sql4);

						echo "<form id='filterForm'>";
						echo "<tr>";
						echo "<th colspan='3'><label>Filtre Seç</label>
								<select name='filtre' id='filtre'>
									<option value=''>Filtreler</option>";
						for ($i = 0; $i < count($filtre); $i++) {
							echo "<option value='$i'>" . $filtre[$i] . "</option>";
						}
						echo "</select></th>";
						echo "<th colspan='2'><input type='button' value='Seç' id='filtreleButton2'></th>";
						echo "</tr>";
						echo "</form>";
						$sqlmesai="select * from mesai";
						$resultm=mysqli_query($baglanti,$sqlmesai);
						$rowm=mysqli_fetch_all($resultm);
						$mesailer=[];
						$verimler=[];
						for($m=0;$m<count($rowm);$m++)
						{
							$mid=$rowm[$m][0];
							$pid=$rowm[$m][1];
							$zamanm=$rowm[$m][2];
							$durumm=$rowm[$m][3];
							$personel=array($mid,$pid,$zamanm,$durumm);
							$mesailer[]=$personel;
						}
						$id=$mesailer[0][0];
						$p=$mesailer[0][1];
						$zaman=$mesailer[0][2];
						$durum=$mesailer[0][3];
						$persayisi=0;
						//VERİM = (TOTAL SİPARİS)/(SAAT * KİŞİ SAYISI)
						for($i=0;$i<count($mesailer);$i++)
						{
							$ids=$mesailer[$i][0];
							$ps=$mesailer[$i][1];
							$zamans=$mesailer[$i][2];
							$durums=$mesailer[$i][3];
							if($durums==0)
							{
								$persayisi++;
							}
							else
							{
								$persayisi--;
							}
							if($persayisi==0)
							{
								$persayisi++;
							}
							if($durums!=$durum and $ps==$p)
							{
								$sqlv="select * from siparis
								where zaman > '$zaman' and zaman < '$zamans';";
								$resultv=mysqli_query($baglanti,$sqlv);
								$count=mysqli_num_rows($resultv);
								$bitis=strtotime($zamans);
								$basla=strtotime($zaman);
								$fark=$bitis-$basla;
								$fark=(float) ($fark/(60*60));
								if($fark!=0)
								{
									$verim=(float) ($count)/($fark * $persayisi);
									$verims=array($ids,$ps,$verim);
									$verimler[]=$verims;
								}
								$id=$ids;
								$p=$ps;
								$zaman=$zamans;
								$durum=$durums;
							}
							else if($durums==$durum and $ps!=$p)
							{
								$sqlv="select * from siparis
								where zaman > '$zaman' and zaman < '$zamans';";
								$resultv=mysqli_query($baglanti,$sqlv);
								$count=mysqli_num_rows($resultv);
								$bitis=strtotime($zamans);
								$basla=strtotime($zaman);
								$fark=$bitis-$basla;
								$fark=floor($fark/(60*60));
								$fark++;
								if($fark!=0)
								{
									$verim=(float)($count)/($fark * $persayisi);
									$verims=array($ids,$ps,$verim);
									$verimler[]=$verims;
								}
								$id=$ids;
								$p=$ps;
								$zaman=$zamans;
								$durum=$durums;
							}
							else if($durums!=$durum and $ps!=$p)
							{
								$id=$ids;
								$p=$ps;
								$zaman=$zamans;
								$durum=$durums;
							}
							echo $fark."\n";
						}
						echo"<pre>";
						print_r($verimler);
						echo"</pre>";
						?>