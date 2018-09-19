<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 17/07/2018
 * Time: 5:01 CH
 */

namespace Aht\BannerSlider\Api\Data;

interface BannerSlideInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID                    = 'id';
    const BANNER_ID             = 'banner_id';
    const SLIDE_ID              = 'slide_id';
    const POSITION              = 'position';
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
    public function getBannerId();

    /**
     * Get Slide Id
     *
     * @return string|null
     */
    public function getSlideId();

    /**
     * Get Position
     *
     * @return string|null
     */
    public function getPosition();

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
     * Set Banner Id
     *
     * @param string $banner_id
     * @return $this
     */
    public function setBannerId($banner_id);

    /**
     * Set Slide Id
     *
     * @param string $slide_id
     * @return $this
     */
    public function setSlideId($slide_id);

    /**
     * Set Position
     *
     * @param string $position
     * @return $this
     */
    public function setPosition($position);

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