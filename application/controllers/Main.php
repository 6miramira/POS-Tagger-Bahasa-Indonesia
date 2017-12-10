<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load->view('index');
	}

	public function unigram($data){
		
		$data = preg_split('/[\n\t]/',$data);
		/*echo "<pre>";
		print_r($data);
		echo "</pre>";*/
		$mUnigram = array();
		$i=0;
		$max = count($data)-1;
		foreach ($data as $kata) {
			$kata=strtolower($kata);
			if($i!=0 && $i!=$max){
				
				if(array_key_exists($kata,$mUnigram)){
					$mUnigram[$kata]["jumlah"]++;
				}else{
					$mUnigram[$kata] = array(
						'kata' => $kata,
						'jumlah' => 1,
						);
				}
			}
			$i++;
		}
		return $mUnigram;
		
	}

	public function bigram($data,$mUnigram){
		
		$data = preg_split('/[\n]/',$data);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		$mBigram = array();
		$i=0;
		$subkalimat = array();
		foreach ($data as $kalimat) {
			$subkalimat[] = explode("\t", $kalimat);
			
			if($subkalimat[$i][0] == " "){
				$subkalimat[$i][0] = "START";
				for($j = count($subkalimat[$i])-1; $j>0;$j--){
					if($subkalimat[$i][$j] == "" || $subkalimat[$i][$j] == "\n" || $subkalimat[$i][$j] == " "){
						unset($subkalimat[$i][$j]);
					}
					$subkalimat[$i][$j] = strtolower($subkalimat[$i][$j]);
					
				}
			}else{
				for($j = count($subkalimat[$i]); $j>0;$j--){
					$subkalimat[$i][$j] = strtolower($subkalimat[$i][$j-1]);
					if($subkalimat[$i][$j] == "" || $subkalimat[$i][$j] == "\n" || $subkalimat[$i][$j] == " "){
						unset($subkalimat[$i][$j]);
					}
				}
				$subkalimat[$i][0] = "START";
			}

			$subkalimat[$i][count($subkalimat[$i])] = "END";
			if($i>0){

				for($j = 1; $j<count($subkalimat[$i])-1;$j++){
					if(isset($subkalimat[$i][$j])){
					//echo $subkalimat[$i][$j]." ";
						if(array_key_exists($subkalimat[$i][$j-1]." ".$subkalimat[$i][$j],$mBigram)){
							if($subkalimat[$i][$j] == $mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]]['jenis'] && $subkalimat[$i-1][$j] == $mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]]['jenis_sebelumnya']){
								$mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]]["jumlah"]++;
							}else{
								if($subkalimat[$i][$j-1] == "START"){
									$mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]] = array(
										'bigram' => $subkalimat[$i][$j-1]." ".$subkalimat[$i][$j],
										'kata' => $subkalimat[$i][$j],
										'jenis' => $subkalimat[$i][$j+1],
										'jenis_sebelumnya' => "START",
										'jumlah' => 1,
										);
								}else{

									$mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]] = array(
										'bigram' => $subkalimat[$i][$j-1]." ".$subkalimat[$i][$j],
										'kata' => $subkalimat[$i][$j-1],
										'jenis' => $subkalimat[$i][$j],
										'jenis_sebelumnya' => $subkalimat[$i-1][$j],
										'jumlah' => 1,
										);
								}
							}
						}else{
							if($subkalimat[$i][$j-1] == "START"){
								$mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]] = array(
									'bigram' => $subkalimat[$i][$j-1]." ".$subkalimat[$i][$j],
									'kata' => $subkalimat[$i][$j],
									'jenis' => $subkalimat[$i][$j+1],
									'jenis_sebelumnya' => "START",
									'jumlah' => 1,
									);
							}else{

								$mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]] = array(
									'bigram' => $subkalimat[$i][$j-1]." ".$subkalimat[$i][$j],
									'kata' => $subkalimat[$i][$j-1],
									'jenis' => $subkalimat[$i][$j],
									'jenis_sebelumnya' => $subkalimat[$i-1][$j],
									'jumlah' => 1,
									);
							}
						}
					}else{
					//echo "aaaa ";
						$var = 1;
						while(!isset($subkalimat[$i][$j])){
							$var++;
							$j++;
						}
						if(array_key_exists($subkalimat[$i][$j-$var]." ".$subkalimat[$i][$j],$mBigram)){
							if($subkalimat[$i][$j] == $mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]]['jenis'] && $subkalimat[$i-1][$j] == $mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]]['jenis_sebelumnya']){
								$mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]]["jumlah"]++;
							}else{
								if($subkalimat[$i][$j-1] == "START"){
									$mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]] = array(
										'bigram' => $subkalimat[$i][$j-1]." ".$subkalimat[$i][$j],
										'kata' => $subkalimat[$i][$j],
										'jenis' => $subkalimat[$i][$j+1],
										'jenis_sebelumnya' => "START",
										'jumlah' => 1,
										);
								}else{
									$mBigram[$subkalimat[$i][$j-$var]." ".$subkalimat[$i][$j]] = array(
										'bigram' => $subkalimat[$i][$j-$var]." ".$subkalimat[$i][$j],
										'kata' => $subkalimat[$i][$j-$var],
										'jenis' => $subkalimat[$i][$j],
										'jenis_sebelumnya' => $subkalimat[$i-1][$j],
										'jumlah' => 1,
										);
								}
							}
							$mBigram[$subkalimat[$i][$j-$var]." ".$subkalimat[$i][$j]]["jumlah"]++;
						}else{
							if($subkalimat[$i][$j-1] == "START"){
								$mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]] = array(
									'bigram' => $subkalimat[$i][$j-1]." ".$subkalimat[$i][$j],
									'kata' => $subkalimat[$i][$j],
									'jenis' => $subkalimat[$i][$j+1],
									'jenis_sebelumnya' => "START",
									'jumlah' => 1,
									);
							}else{
								$mBigram[$subkalimat[$i][$j-$var]." ".$subkalimat[$i][$j]] = array(
									'bigram' => $subkalimat[$i][$j-$var]." ".$subkalimat[$i][$j],
									'kata' => $subkalimat[$i][$j-$var],
									'jenis' => $subkalimat[$i][$j],
									'jenis_sebelumnya' => $subkalimat[$i-1][$j],
									'jumlah' => 1,
									);
							}
						}
					}
				}
			}
			
					//echo "bbb ";
			$i++;
		}
		// echo "<pre>";
		// print_r($subkalimat);
		// echo "</pre>";
		

		return $mBigram;
	}

	

	public function tagger(){
		$namefile = "UI_corpus_indonesia.txt";
		$link = base_url();
		$link .="data/".$namefile;
		//echo "$link";
		$mUnigram = $this->unigram(file_get_contents($link));
		
		$mBigram = $this->bigram(file_get_contents($link),$mUnigram);
		
		
		
		
		
		// echo "<pre>";
		// print_r($unigram10besar);
		// echo "</pre>";
		// echo "<pre>";
		// print_r($bigram10besar);
		// echo "</pre>";
	
		
	

		$post = $this->input->post();

		if(isset($post['tag'])){
			$kata = array();
			$jenis = array();
			$persentase;
			$n = $post['tag'];
			echo "$n<br>";
			$i=0;
			$k=0;
			$subkalimat[] = explode(" ", $n);
			for($j=0;$j<count($subkalimat[$i]);$j++){

				$kata[$j] = $subkalimat[$i][$j];
				if($j==0){
					$kalimat = count($mBigram);
					foreach ($mBigram as $bigram) {
						//echo $bigram['kata']."<br>";
						if($bigram['kata'] == $subkalimat[$i][$j] && $bigram['jenis_sebelumnya']=="START"){
							$jml[$k] = $bigram;
							$jml[$k]['persentase'] = $bigram['jumlah']/$kalimat;
							$k++;
						}
					}
					$max = 0;
					for($l=0;$l<$k;$l++){
						if($jml[$l]> $max){
							$max = $jml[$l];
								
							$jenis[$j] = $jml[$l]['jenis'];
							$persentase[$j] = $jml[$l]['persentase'];

						}
					}
				}else{
					$namefile = "UI_tagset_indonesia.txt";
					$link = base_url();
					$link .="data/".$namefile;
					$data = file_get_contents($link);

					$data = preg_split('/[\n]/',$data);
					$n = 0;
					$subtag = "";
					$emisitag = "";
					foreach ($data as $tag) {
						$tag = strtolower($tag);
						$subtag[$jenis[$j-1]." ".$tag]['jumlah'] = 0;
						$subtag[$jenis[$j-1]." ".$tag]['jenis'] = $tag;
						$subtag[$jenis[$j-1]." ".$tag]['jenis_sebelumnya'] = $jenis[$j-1];
						$emisitag[$kata[$j]." ".$tag]['jumlah'] = 0;
						$emisitag[$kata[$j]." ".$tag]['jenis'] = $tag;
						$emisitag[$kata[$j]." ".$tag]['kata'] = $kata[$j]; 
						foreach ($mBigram as $bigram) {
							if($bigram['jenis'] == $tag && $bigram['jenis_sebelumnya'] == $jenis[$j-1]){
								$subtag[$jenis[$j-1]." ".$tag]['jumlah'] += $bigram['jumlah']/$mUnigram[$tag]['jumlah']; 
							}
							if($bigram['kata'] == $kata[$j] && $bigram['jenis'] == $tag){
							$emisitag[$kata[$j]." ".$tag]['jumlah'] += $bigram['jumlah']/$mUnigram[$tag]['jumlah']; 
							}
						}
					}

					$max = 0;
					$temp=0;
					foreach ($emisitag as $sub) {
						$temp=0;
						// echo $sub['jumlah']."<br>";
						// echo $subtag[$jenis[$j-1]." ".$sub['jenis']]['jumlah']."<br>";
						$temp = $sub['jumlah']*$subtag[$jenis[$j-1]." ".$sub['jenis']]['jumlah'];
						
						if($temp > $max){
							$max = $temp;
							$jenis[$j] = $sub['jenis'];
							$persentase[$j] = $temp;
						}
					}
				}
				//echo $subkalimat[$i][$j]."<br>";
			}
			for($j=0;$j<count($subkalimat[$i]);$j++){
				echo $kata[$j]."/".$jenis[$j]."(".$persentase[$j].")  ";
			}

		}

		// $data1 = $mUnigram;
		// $data2 = $mBigram;
		
		// usort($mUnigram, function($a, $b) {
		//     return $a['jumlah'] < $b['jumlah'];
		// });

		// usort($mBigram, function($a, $b) {
		//     return $a['jumlah'] < $b['jumlah'];
		// });

		// $unigram10besar = array_slice($mUnigram,0,10);
		// $bigram10besar = array_slice($mBigram,0,10);

		// $data = array(
  //           'mUnigram' => $data1,
  //           'mBigram' => $data2,
  //           'unigram10besar' => $unigram10besar,
  //           'bigram10besar' => $bigram10besar,
  //       );
		
		// $this->load->view('index',$data);
	}
}