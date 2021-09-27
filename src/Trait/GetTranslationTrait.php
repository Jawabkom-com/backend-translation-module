<?php

namespace Jawabkom\Backend\Module\Translation\Trait;

use Jawabkom\Backend\Module\Translation\Exception\FilterNameDoesNotExistsException;
use Jawabkom\Standard\Contract\IAndFilterComposite;
use Jawabkom\Standard\Contract\IFilter;
use Jawabkom\Standard\Contract\IOrderBy;

trait GetTranslationTrait
{
    protected  array $filterNames = ['group_name', 'language_code', 'country_code', 'key', 'value','created_at','updated_at'];

    //
    // LEVEL 1
    //
    protected function buildCompositeFilterObject(array $filtersInput): IAndFilterComposite
    {
        /**@var $compositeAndFilter IAndFilterComposite */
        $compositeAndFilter = $this->di->make(IAndFilterComposite::class);
        foreach ($filtersInput as $filterName => $filterValue) {
             if (in_array($filterName, $this->filterNames)) {
                /**@var $filterObj IFilter */
                $filterObj = $this->di->make(IFilter::class);
                $compositeAndFilter->addChild($filterObj->setName($filterName)->setValue($filterValue));
            }
        }
        return $compositeAndFilter;
    }

    protected function validateFilters(array $filtersInput)
    {
        if(!empty($filtersInput)){
            foreach($filtersInput as $filterName => $filterValue) {
                if(!in_array($filterName, $this->filterNames)) {
                    throw new FilterNameDoesNotExistsException("Filter name [{$filterName}]");
                }
            }
        }

    }

    protected function buildCompositeOrderByObject($orderByInput):array
    {
        $orderBy = [];
        foreach ($orderByInput as $column => $by) {
            if (in_array($column, $this->filterNames)) {
                /**@var $orderByObj IOrderBy */
                $orderByObj = $this->di->make(IOrderBy::class);
                $orderBy[] = $orderByObj->setFieldName($column)->setIsDescending(trim(strtolower($by)) == 'desc' ? true : false);
            }
        }
        return $orderBy;
    }
}
