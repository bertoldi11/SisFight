<?php

class Formatacao extends CFormatter 
{
	
	public static function formatCPFCNPJ($valor)
	{
		// pega o tamanho da string menos os digitos verificadores
		$tamanho = (strlen($valor) -2);
		//verifica se o tamanho do código informado é válido
		if ($tamanho != 9 && $tamanho != 12)
		{
			return $campo; 
		}	 
	
		$mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##'; 
	 
		$indice = -1;
		for ($i=0; $i < strlen($mascara); $i++) 
		{
			if ($mascara[$i]=='#') 
				$mascara[$i] = $valor[++$indice];
		}
		//retorna o campo formatado
		return $mascara;
	}
	
	/**
	 * Inverte os valores da data
	 * @param date $data data que será invertida
	 * @param string $separador caractere que será utilizado para separar a data
	 * @param string $cola caractere que será utilizado para juntar a data
	 * @return data invertida
	 */
	public static function formatData($data, $separador='-', $cola='/')
	{	
		if(empty($data) || is_null($data) || $data == '0000-00-00' || $data == '00/00/0000')
			return '';

        $novaData = explode(' ',$data);
        $hora = '';
        if(count($novaData) > 1)
        {
            $data = $novaData[0];
            $hora = ' '.$novaData[1];
        }


		$date = explode($separador, $data);	
		return $date[2].$cola.$date[1].$cola.$date[0].$hora;
	}
}
?>