<?php namespace ZN\Hypertext;
/**
 * ZN PHP Web Framework
 * 
 * "Simplicity is the ultimate sophistication." ~ Da Vinci
 * 
 * @package ZN
 * @license MIT [http://opensource.org/licenses/MIT]
 * @author  Ozan UYKUN [ozan@znframework.com]
 */

trait BootstrapGridsystemTrait
{
    /**
     * Protected bootstrap grid system column
     * 
     * @var string
     */
    protected $bootstrapGridsystemCol = NULL;

    /**
     * Protected bootstrap grid system row
     * 
     * @var string
     */
    protected $bootstrapGridsystemRow = NULL;


    /**
     * Protected bootstrap grid sytem column count
     * 
     * @var int 
     */
    protected $bootstrapGridsystemColumnCount = 0;

    /**
     * Magic to string
     * 
     * @return string
     */
    public function __toString()
    {
        if( $this->getBootstrapGridsystem() )
        {
            return $this->createBootstrapGridsystem();
        }
    }

    /**
     * Container fluid
     * 
     * @return this
     */
    public function fluid()
    {
        $this->bootstrapContainerDivElementAttributes = 'container-fluid';

        return $this;
    }

    /**
     * Protected bootstrap column
     */
    protected function bootstrapColumn($content, $match)
    {
        $parts = $this->getGridsystemColumMethodParts($match);

        $this->bootstrapGridsystemCol .= $this->class($this->getGridsytemColumnClass($parts))->div($content);

        $this->bootstrapGridsystemColumnCount += (int) $parts['number'];

        if( $this->bootstrapGridsystemColumnCount === 12 )
        {
            $this->bootstrapGridsystemRow .= $this->class('row')->div($this->bootstrapGridsystemCol ?: '');

            $this->bootstrapGridsystemCol = '';

            $this->bootstrapGridsystemColumnCount = 0;
        } 
    } 

    /**
     * Protected is bootstrap column
     */
    protected function isBootstrapColumn($method, &$match)
    {
        return preg_match('/col(?<type>[a-z][a-z])(?<number>[0-9]{1,})*/', $method, $match);
    }   

    /**
     * Protected get grid system column method parts
     */
    protected function getGridsystemColumMethodParts($match)
    {
        return ['name' => 'col', 'type' => $match['type'], 'number' => $match['number'] ?? 1];
    }

    /**
     * Protected get grid system column class
     */
    protected function getGridsytemColumnClass($parts)
    {
        return implode('-', $parts);
    }

    /**
     * Protected get bootstrap grid system
     */
    protected function getBootstrapGridsystem()
    {
        return $this->bootstrapGridsystemRow ?: $this->bootstrapGridsystemCol ?: '';
    }

    /**
     * Protected create bootstrap grid system
     */
    protected function createBootstrapGridsystem()
    {
        $return = $this->class($this->bootstrapContainerDivElementAttributes ?? 'container')->div($this->getBootstrapGridsystem());

        $this->bootstrapGridsystemRow = '';

        return $return;
    }
}
