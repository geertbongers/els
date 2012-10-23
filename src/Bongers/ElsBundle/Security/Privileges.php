<?php
namespace Bongers\ElsBundle\Security;

class Privileges
{
    const DEBUG                     = 'DEBUG';

    const ENTITY_LIST               = 'LIST';
    const ENTITY_CREATE             = 'CREATE';
    const ENTITY_READ               = 'READ';
    const ENTITY_UPDATE             = 'UPDATE';
    const ENTITY_DELETE             = 'DELETE';
    const ENTITY_CRUD               = 'CRUD';

    const ENTITY_INVITE             = 'INVITE';
    const ENTITY_SHOW_OTHER_TESTS   = 'SHOW_OTHER_TESTS';
    const ENTITY_FINALIZE           = 'FINALIZE';
}
