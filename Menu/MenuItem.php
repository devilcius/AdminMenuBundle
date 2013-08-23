<?php

namespace devilcius\AdminMenuBundle\Menu;

use Knp\Menu\MenuItem as BaseItem;


class MenuItem extends BaseItem
{
    protected $translationDomain = null;
    protected $roles = null;
    protected $displayLink = true;
    protected $displayLabel = true;
    protected $nbDividers = 0;

    /**
     * Gets TranslationDomain
     * 
     * @return [type]
     */
    public function getTranslationDomain()
    {
        return $this->translationDomain;
    }
    
    /**
     * Sets TranslationDomain
     * 
     * @param [type] $translationDomain TranslationDomain
     * 
     * @return [type]
     */
    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
        return $this;
    }

    /**
     * Gets Roles
     * 
     * @return [type]
     */
    public function getRoles()
    {
        return $this->roles;
    }
    
    /**
     * Sets roles
     * 
     * @param [type] $roles roles
     * 
     * @return [type]
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Gets DisplayLink
     * 
     * @return [type]
     */
    public function isLinkDisplayed()
    {
        return $this->displayLink;
    }
    
    /**
     * Sets DisplayLink
     * 
     * @param [type] $displayLink DisplayLink
     * 
     * @return [type]
     */
    public function setDisplayLink($displayLink)
    {
        $this->displayLink = $displayLink;
        return $this;
    }

    /**
     * Gets DisplayLabel
     * 
     * @return [type]
     */
    public function isLabelDisplayed()
    {
        return $this->displayLabel;
    }
    
    /**
     * Sets DisplayLabel
     * 
     * @param [type] $displayLabel DisplayLabel
     * 
     * @return [type]
     */
    public function setDisplayLabel($displayLabel)
    {
        $this->displayLabel = $displayLabel;
        return $this;
    }
    
    /**
     * Add a divider
     *
     * @return devilcius\AdminMenuBundle\Menu\MenuItem
     */
    public function addDivider()
    {
        $name = $this->getName().'_divider_'.$this->nbDividers;
        $child = $this->factory->createItem($name);

        $child->setParent($this);
        $child->setCurrentUri($this->getCurrentUri());

        $child->setChildrenAttribute('class', 'divider');
        $child->setDisplayLink(false);
        $child->setDisplayLabel(false);

        $this->children[$child->getName()] = $child;

        $this->nbDividers++;
        return $child;
    }

    /**
     * Add a divider
     *
     * @param string $name Nav header label
     *
     * @return devilcius\AdminMenuBundle\Menu\MenuItem
     */
    public function addNavHeader($name)
    {
        $child = $this->factory->createItem($name);

        $child->setParent($this);
        $child->setCurrentUri($this->getCurrentUri());

        $child->setChildrenAttribute('class', 'nav-header');
        $child->setDisplayLink(false);

        $this->children[$child->getName()] = $child;

        return $child;
    }

    /**
     * Remove and return a menu
     *
     * @param string $name [description]
     *
     * @return devilcius\AdminMenuBundle\Menu\MenuItem
     */
    public function pop($name)
    {
        $menu = $this[$name];
        $this->removeChild($name);
        return $menu;
    }
    
    
}
