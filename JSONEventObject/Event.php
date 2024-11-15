<?php
//This is a class file for the wdv341_events table
//documentation: description, author, build date, project number, etc. . .
//Author: Misti C
//Date: 10/22/2024

class Event{
    //properties: includes constructors
        //Access Identifiers:
            //public: anyone can access
            //private: noone can change it except through setters
            //protected: similar to private but inheritable

    private $eventsID;
    private $eventsName;
    private $eventsDescription;
    private $eventsPresenter;
    private $eventsDate;
    private $eventsTime;
        //if its not listed as a property than it can't have any information stored about it
        

    //constructor method - sets the default values of the properties in the NEW object
            //DOES NOT CREATE THE NEW OBJECT
    function _construct(){  //usually use an empty (no parameters) constructor  -construct() defines the constructor method but to call use the class name
        //set the default values of the properties of the new object
        $this -> eventsID = 0;
        $this -> eventsName = "";
        $this -> eventsDescription = "";
        $this -> eventsPresenter = "";
        $this -> eventsDate = "";
        $this -> eventsTime = "";
    }
    //this: possesive identifier; use the object your accessing and modify the correct object property


    //methods: setters/getters

        //setters/getters also: accessors/mutators
            //setter - takes an input value and applies it to a property
                //validate data
                //return a message
                //
            //getter - returns the value of a property

    function setEventsID($inID){
        $this->eventsID = $inID;    //assign the input value to a property
    }

    function getEventsID(){         //return the value to the function call
        return $this->eventsID;    
    }

    function setEventsName($inName){
        $this->eventsName = $inName;    
    }

    function getEventsName(){
        return $this->eventsName;    
    }

    function setEventsDescription($inDescription){
        $this->eventsDescription = $inDescription;    
    }

    function getEventsDescription(){
        return $this->eventsDescription;    
    }

    function setEventsPresenter($inPresenter){
        $this->eventsPresenter = $inPresenter;    
    }

    function getEventsPresenter(){
        return $this->eventsPresenter;    
    }

    function setEventsDate($inDate){
        $this->eventsDate = $inDate;    
    }

    function getEventsDate(){
        return $this->eventsDate;    
    }

    function setEventsTime($inTime){
        $this->eventsTime = $inTime;    
    }

    function getEventsTime(){
        return $this->eventsTime;    
    }

        //processing methods
}
?>