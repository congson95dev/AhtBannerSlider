<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 17/07/2018
 * Time: 5:01 CH
 */

namespace Aht\BannerSlider\Api\Data;

interface PageInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID                    = 'id';
    const PAGE_NAME             = 'page_name';
    const PAGE_URL              = 'page_url';
    const CREATED_AT            = 'created_at';
    const UPDATED_AT            = 'updated_at';
    /**#@-*/


    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Banner Id
     *
     * @return string|null
     */
    public function getPageName();

    /**
     * Get Page url
     *
     * @return string|null
     */
    public function getPageUrl();

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get Updated At
     *
     * @return string|null
     */
    public function getUpdatedAt();


    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Set Page Name
     *
     * @param string $page_name
     * @return $this
     */
    public function setPageName($page_name);

    /**
     * Set Page Url
     *
     * @param string $page_url
     * @return $this
     */
    public function setPageUrl($page_url);

    /**
     * Set Created At
     *
     * @param int $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Set Updated At
     *
     * @param int $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}