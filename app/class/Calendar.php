<?php

/**
@author Deyvison Estevam <deyvison_rodrigo@hotmail.com>
**/

class Calendar {
    
    const D_FORMAT = 'Y-m-d';	//formato padrão(América)
    const B_FORMAT = 'd/m/Y'; //Formato brasil
	const SECOND = 60; //Segundos em minuto
	const MIN = 60; //Minutos em hora
	const HOUR = 24; //Horas em dia
	const SECONDS_DAY = self::SECOND*self::MIN*self::HOUR; //Segundos em dia
	const NUM_LINES_BLOCO = 6; //Número de linhas em um bloco/mês


	function __construct(){
		
	}

	//Validar Formato
	public function validate(){
		return true;
	}

	public function getDateArray($date){
		$time = strtotime($date);

		$dateArray = [
			'd' => date('d', $time),
			'm' => date('m', $time),
			'y' => date('Y', $time)
		];

		return $dateArray;
	}


	public function subtrairDias(string $date, int $dias){
		return date(self::D_FORMAT, ( strtotime($date) - $dias*self::SECONDS_DAY) );
	}

	public function somarDias(string $date, int $dias){
		return date(self::D_FORMAT, ( strtotime($date) + $dias*self::SECONDS_DAY) );
	}

	public function getDayOfWeek(string $date){
		$t = strtotime($date);
		return [date('w', $t) => date('l', $t)];
	}

	public function nextMonth(string $date){	
		$dateArray = $this->getDateArray($date); 
		
		if($dateArray['m']+1 > 12){
			$dateArray['m'] = 1;
			$dateArray['y'] += 1;
		}else{
			$dateArray['m'] += 1;
		}

		return date('Y-m-d', strtotime($dateArray['y'].'-'.$dateArray['m'].'-01'));
	}

	public function lastMonth(string $date){	
		$dateArray = $this->getDateArray($date); 
		
		if($dateArray['m']-1 <= 0){
			$dateArray['m'] = 12;
			$dateArray['y'] -= 1;
		}else{
			$dateArray['m'] -= 1;
		}

		return date('Y-m-d', strtotime($dateArray['y'].'-'.$dateArray['m'].'-01'));
	}

	public function getPrimeiroDiaBloco($date){
		$dateTime = new DateTime($date);
		$dateTime->modify('first day of this month');
		$newDate = $dateTime->format(self::D_FORMAT);

		$diaSemanaPrimeiroDiaDoMes = date('w', strtotime($newDate));	

		//Se o mês começa no domingo, o bloco do calendário começará no domingo
		// 7 dias antes. 
		if($diaSemanaPrimeiroDiaDoMes == 0)
			$diaSemanaPrimeiroDiaDoMes = 7;

		return $this->subtrairDias($newDate, $diaSemanaPrimeiroDiaDoMes);
	}

	public function getUltimoDiaBloco($date){
		$dateTime = new DateTime($date);
		$dateTime->modify('last day of this month');
		$newDate = $dateTime->format(self::D_FORMAT);

		$diaSemanaUltimoDiaDoMes = date('w', strtotime($newDate));		

		return $this->somarDias($newDate, (13 - $diaSemanaUltimoDiaDoMes));
	}

	//Verifica se as datas pertencem ao mesmo mes e ano
	public function dataMesmoMes($date1, $date2){
		$time1 = strtotime($date1);
		$time2 = strtotime($date2);		

		if(date('mY', $time1) == date('mY', $time2))
			return true;

		return false; 
	}

	public function toBr(string $date){
		return date(self::B_FORMAT, strtotime($date));
	}

	public function dateText(string $date){
		$time = strtotime($date);
		return date('l, d F Y', $time); 
	}

	public function completeCalendarArray(string $date){	
		$primeiraDataBloco = $this->getPrimeiroDiaBloco($date);
		$ultimaDataBloco = $this->getUltimoDiaBloco($date);

		while(strtotime($primeiraDataBloco) <= strtotime($ultimaDataBloco)){
			$time = strtotime($primeiraDataBloco);

			$calendar[$time] = [
				'date' => date(self::D_FORMAT, $time), 
				'dateBr' => date(self::B_FORMAT, $time),
				'dayweek' => $this->getDayOfWeek($primeiraDataBloco),
				'daymonth' => date('d', $time),
				'mesmoMes' => $this->dataMesmoMes($date, $primeiraDataBloco)
			];

			$primeiraDataBloco = $this->somarDias($primeiraDataBloco, 1);		
		}

		return $calendar;
	}

} 