<?php
namespace Bongers\ElsBundle\Security;

class Privileges
{
    const DEBUG                     = 'DEBUG';

    const OBJECT_LIST               = 'LIST';
    const OBJECT_CREATE             = 'CREATE';
    const OBJECT_READ               = 'READ';
    const OBJECT_UPDATE             = 'UPDATE';
    const OBJECT_DELETE             = 'DELETE';
    const OBJECT_CRUD               = 'CRUD';

    const ENTITY_INVITE             = 'INVITE';
    const ENTITY_SHOW_OTHER_TESTS   = 'SHOW_OTHER_TESTS';
    const ENTITY_FINALIZE           = 'FINALIZE';
}
