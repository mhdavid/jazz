<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 15/04/2013
@AUTOR.......: Alcione Giovanella
@ADAPTAÇÃO...: Adriel Vieira <ahdriel@gmail.com>
@ADAPTAÇÃO...: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: jz_date.php
@NOME CODIGO.: Days
@UTILIDADE...: Arquivo de Inicialização do Framework JAZZMVC 1.0
@INTRODUCAO..: JAZZMVC Revision SVN 14
@STATUS......: [X] Construção, [] Operação, [] Manutenção, [] Fora de uso
*******************************************************************************/

class jz_date
	{

	public function jz_date()
		{
		$diasemana[0] = "domingo";                                  
		$diasemana[1] = "segunda-feira";                            
		$diasemana[2] = "terça-feira";                              
		$diasemana[3] = "quarta-feira";                             
		$diasemana[4] = "quinta-feira";                             
		$diasemana[5] = "sexta-feira";                              
		$diasemana[6] = "sábado";                                   
		//----------------------------------------------------------
		$mesnome[1] = "janeiro";                                    
		$mesnome[2] = "fevereiro";                                  
		$mesnome[3] = "março";                                      
		$mesnome[4] = "abril";                                      
		$mesnome[5] = "maio";                                       		
		$mesnome[6] = "junho";                                      
		$mesnome[7] = "julho";                                      
		$mesnome[8] = "agosto";                                     
		$mesnome[9] = "setembro";                                   
		$mesnome[10] = "outubro";                                   
		$mesnome[11] = "novembro";                                  
		$mesnome[12] = "dezembro";                                  
		//----------------------------------------------------------
		$this->ano = date('Y');
		$this->mes = date('n');
		$this->mesEx = $mesnome[date('n')];
		$this->dia = date('d');
		$this->diaSem = date('w');
		$this->hora = getdate(); 
		$this->hr=$this->hora['hours'];
		$this->sec=$this->hora['seconds'];

		if ($this->mes<10)
			{
			$this->mes="0".$this->mes;
			}
		

		if ($this->hora['minutes']<10)
			{
			$this->min="0".$this->hora['minutes'];
			}
		else
			{	
			$this->min=$this->hora['minutes'];
			}

		if ($this->hora['seconds']<10)
			{
			$this->sec="0".$this->hora['seconds'];
			}
		else
			{
			$this->sec=$this->hora['seconds'];
			}
			

	$this->horacerta=($this->hr.':'.$this->min);
	$this->horalog=($this->hr.':'.$this->min.':'.$this->sec);
	}

	// Hora - Corrente
	public function now_h()
		{
			return $this->hora;
		}	

	// Hora:Minuto - Corrente
	public function now_hm()
		{
			return $this->horacerta;
		}	

	// Hora:Minuto:Segundo - Corrente
	public function now_hms ()
		{
			return $this->horalog;
		}

	// Data de Hoje
	public function now_date ()
		{
			return $this->dia.'/'.$this->mes.'/'.$this->ano;
		}

	// Data Dia da Semana
	public function now_wd ()
		{
			return $this->diasem;
		}

	// Data Mês por Extenso
	public function now_mx ()
		{
			return $this->mesEx;
		}

	}