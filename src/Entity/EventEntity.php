<?php

namespace App\Entity;

class EventEntity
{
   
   /**
     * @var mixed Unique identifier of this event (optional).
     */
    protected $id;
	
	/**
     * @var Patient ID.
     */
    protected $idPatient;
	
	/**
     * @var Doctor ID.
     */
    protected $idDoctor;
	
	/**
     * @var Calendar ID.
     */
    protected $idCalendar;
    
    /**
     * @var string note/label of the calendar event.
     */
    protected $note;
    
    /**
     * @var string Title/label of the calendar event.
     */
    protected $title;
	
	/**
     * @var text Body/label of the calendar event.
     */
    protected $body;
	
	/**
     * @var string State/label of the calendar event.
     */
    protected $state;
    
    /**
     * @var string URL Relative to current path.
     */
    protected $url;
    
    /**
     * @var string HTML color code for the bg color of the event label.
     */
    protected $bgColor;
    
    /**
     * @var string HTML color code for the foregorund color of the event label.
     */
    protected $fgColor;
    
    /**
     * @var string css class for the event label
     */
    protected $cssClass;
    
    /**
     * @var \DateTime DateTime object of the event start date/time.
     */
    protected $startDatetime;
    
    /**
     * @var \DateTime DateTime object of the event end date/time.
     */
    protected $endDatetime;
    
    /**
     * @var boolean Is this an all day event?
     */
    protected $allDay = false;

    /**
     * @var array Non-standard fields
     */
    protected $otherFields = array();
    
    public function __construct($id, $idPatient, $idDoctor, $idCalendar, $note, $title, $body, $state, \DateTime $startDatetime, \DateTime $endDatetime = null, $allDay = false)
    {
		$this->id = $id;
		$this->idPatient = $idPatient;
		$this->idDoctor = $idDoctor;
		$this->idCalendar = $idCalendar;
        $this->note = $note;
        $this->title = $title;
		$this->body = $body;
		$this->state = $state;
        $this->startDatetime = $startDatetime;
        $this->setAllDay($allDay);
        
        if ($endDatetime === null && $this->allDay === false) {
            throw new \InvalidArgumentException("Must specify an event End DateTime if not an all day event.");
        }
        
        $this->endDatetime = $endDatetime;
    }

    /**
     * Convert calendar event details to an array
     * 
     * @return array $event 
     */
    public function toArray()
    {
        $event = array();
        
        if ($this->id !== null) {
            $event['id'] = $this->id;
        }
		
		if ($this->idPatient !== null) {
            $event['idPatient'] = $this->idPatient;
        }
		
		if ($this->idDoctor !== null) {
            $event['idDoctor'] = $this->idDoctor;
        }
		
		if ($this->idCalendar !== null) {
            $event['idCalendar'] = $this->idCalendar;
        }
		
		if ($this->body !== null) {
            $event['body'] = $this->body;
        }
		
		if ($this->state !== null) {
            $event['state'] = $this->state;
        }
        
        if ($this->note !== null) {
            $event['note'] = $this->note;
        }
        
		$event['id'] = $this->id;
        $event['title'] = $this->title;
        $event['start'] = $this->startDatetime->format("Y-m-d\TH:i:sP");
		
        
        if ($this->url !== null) {
            $event['url'] = $this->url;
        }
        
        if ($this->bgColor !== null) {
            $event['backgroundColor'] = $this->bgColor;
            $event['borderColor'] = $this->bgColor;
        }
        
        if ($this->fgColor !== null) {
            $event['textColor'] = $this->fgColor;
        }
        
        if ($this->cssClass !== null) {
            $event['className'] = $this->cssClass;
        }

        if ($this->endDatetime !== null) {
            $event['end'] = $this->endDatetime->format("Y-m-d\TH:i:sP");
        }
        
        $event['allDay'] = $this->allDay;

        foreach ($this->otherFields as $field => $value) {
            $event[$field] = $value;
        }
        
        return $event;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
	
	 public function setIdPatient($idPatient)
    {
        $this->idPatient = $idPatient;
    }
    
    public function getIdPatient()
    {
        return $this->idPatient;
    }
	
	 public function setidDoctor($idDoctor)
    {
        $this->idDoctor = $idDoctor;
    }
    
    public function getidDoctor()
    {
        return $this->idDoctor;
    }
	
	 public function setIdCalendar($idCalendar)
    {
        $this->idCalendar = $idCalendar;
    }
    
    public function getIdCalendar()
    {
        return $this->idCalendar;
    }
    
    public function setTitle($title) 
    {
        $this->title = $title;
    }
    
    public function getTitle() 
    {
        return $this->title;
    }
	
	 public function setBody($body) 
    {
        $this->body = $body;
    }
    
    public function getBody() 
    {
        return $this->body;
    }
	
	 public function setState($state) 
    {
        $this->state = $state;
    }
    
    public function getState() 
    {
        return $this->state;
    }
    
     public function setNote($note) 
    {
        $this->note = $note;
    }
    
    public function getNote() 
    {
        return $this->note;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function setBgColor($color)
    {
        $this->bgColor = $color;
    }
    
    public function getBgColor()
    {
        return $this->bgColor;
    }
    
    public function setFgColor($color)
    {
        $this->fgColor = $color;
    }
    
    public function getFgColor()
    {
        return $this->fgColor;
    }
    
    public function setCssClass($class)
    {
        $this->cssClass = $class;
    }
    
    public function getCssClass()
    {
        return $this->cssClass;
    }
    
    public function setStartDatetime(\DateTime $start)
    {
        $this->startDatetime = $start;
    }
    
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }
    
    public function setEndDatetime(\DateTime $end)
    {
        $this->endDatetime = $end;
    }
    
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }
    
    public function setAllDay($allDay = false)
    {
        $this->allDay = (boolean) $allDay;
    }
    
    public function getAllDay()
    {
        return $this->allDay;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function addField($name, $value)
    {
        $this->otherFields[$name] = $value;
    }

    /**
     * @param string $name
     */
    public function removeField($name)
    {
        if (!array_key_exists($name, $this->otherFields)) {
            return;
        }

        unset($this->otherFields[$name]);
    }


    public function __toString()
    {
        return $this->getIdCalendar();
    }

}
